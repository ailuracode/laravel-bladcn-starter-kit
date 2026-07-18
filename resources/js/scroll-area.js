export function registerScrollArea() {
    bladcnRegister("bladcnScrollArea", () => ({
        resizeObserver: null,
        onSidebarLayout: null,
        hasVerticalOverflow: false,

        getTrack(orientation) {
            const thumb = this.$refs[`${orientation}Thumb`];

            return thumb?.parentElement ?? null;
        },

        updateThumbs() {
            const viewport = this.$refs.viewport;

            if (!viewport) {
                return;
            }

            this.hasVerticalOverflow = viewport.scrollHeight > viewport.clientHeight + 1;

            this.updateThumb("vertical", viewport);
            this.updateThumb("horizontal", viewport);
        },

        updateThumb(orientation, viewport) {
            const thumb = this.$refs[`${orientation}Thumb`];
            const track = this.getTrack(orientation);

            if (!thumb || !track) {
                return;
            }

            if (orientation === "vertical") {
                const trackHeight = track.clientHeight;

                if (!this.hasVerticalOverflow || trackHeight <= 0) {
                    thumb.style.height = "0px";
                    thumb.style.width = "";
                    thumb.style.top = "0px";
                    thumb.style.left = "";
                    thumb.style.transform = "";

                    return;
                }

                const ratio = viewport.clientHeight / viewport.scrollHeight;
                const thumbHeight = Math.max(ratio * trackHeight, 24);
                const maxScroll = viewport.scrollHeight - viewport.clientHeight;
                const maxThumbOffset = trackHeight - thumbHeight;
                const thumbOffset =
                    maxScroll > 0 ? (viewport.scrollTop / maxScroll) * maxThumbOffset : 0;

                thumb.style.width = "100%";
                thumb.style.height = `${thumbHeight}px`;
                thumb.style.top = `${thumbOffset}px`;
                thumb.style.left = "0";
                thumb.style.transform = "";

                return;
            }

            const trackWidth = track.clientWidth;

            if (viewport.scrollWidth <= viewport.clientWidth || trackWidth <= 0) {
                thumb.style.width = "0px";
                thumb.style.height = "";
                thumb.style.left = "0px";
                thumb.style.top = "";
                thumb.style.transform = "";

                return;
            }

            const ratio = viewport.clientWidth / viewport.scrollWidth;
            const thumbWidth = Math.max(ratio * trackWidth, 24);
            const maxScroll = viewport.scrollWidth - viewport.clientWidth;
            const maxThumbOffset = trackWidth - thumbWidth;
            const thumbOffset =
                maxScroll > 0 ? (viewport.scrollLeft / maxScroll) * maxThumbOffset : 0;

            thumb.style.height = "100%";
            thumb.style.width = `${thumbWidth}px`;
            thumb.style.left = `${thumbOffset}px`;
            thumb.style.top = "0";
            thumb.style.transform = "";
        },

        scrollByThumbPointer(event, orientation) {
            if (event.target?.closest('[data-slot="scroll-area-thumb"]')) {
                return;
            }

            const viewport = this.$refs.viewport;
            const thumb = this.$refs[`${orientation}Thumb`];
            const track = this.getTrack(orientation);

            if (!viewport || !thumb || !track) {
                return;
            }

            const trackRect = track.getBoundingClientRect();
            const thumbRect = thumb.getBoundingClientRect();
            const pointer = orientation === "vertical" ? event.clientY : event.clientX;
            const trackStart = orientation === "vertical" ? trackRect.top : trackRect.left;
            const trackSize = orientation === "vertical" ? trackRect.height : trackRect.width;
            const thumbSize = orientation === "vertical" ? thumbRect.height : thumbRect.width;
            const maxScroll =
                orientation === "vertical"
                    ? viewport.scrollHeight - viewport.clientHeight
                    : viewport.scrollWidth - viewport.clientWidth;

            if (maxScroll <= 0 || trackSize <= thumbSize) {
                return;
            }

            const maxThumbOffset = trackSize - thumbSize;
            const clickOffset = Math.min(
                Math.max(pointer - trackStart - thumbSize / 2, 0),
                maxThumbOffset,
            );

            if (orientation === "vertical") {
                viewport.scrollTop = (clickOffset / maxThumbOffset) * maxScroll;
            } else {
                viewport.scrollLeft = (clickOffset / maxThumbOffset) * maxScroll;
            }

            this.updateThumbs();
        },

        startThumbDrag(event, orientation) {
            event.preventDefault();
            event.stopPropagation();

            const viewport = this.$refs.viewport;
            const thumb = this.$refs[`${orientation}Thumb`];
            const track = this.getTrack(orientation);

            if (!viewport || !thumb || !track) {
                return;
            }

            const trackRect = track.getBoundingClientRect();
            const thumbRect = thumb.getBoundingClientRect();
            const startPointer = orientation === "vertical" ? event.clientY : event.clientX;
            const startThumbOffset =
                orientation === "vertical"
                    ? thumbRect.top - trackRect.top
                    : thumbRect.left - trackRect.left;
            const trackSize = orientation === "vertical" ? trackRect.height : trackRect.width;
            const thumbSize = orientation === "vertical" ? thumbRect.height : thumbRect.width;
            const maxScroll =
                orientation === "vertical"
                    ? viewport.scrollHeight - viewport.clientHeight
                    : viewport.scrollWidth - viewport.clientWidth;
            const maxThumbOffset = Math.max(trackSize - thumbSize, 0);

            const onMove = (moveEvent) => {
                if (maxThumbOffset <= 0 || maxScroll <= 0) {
                    return;
                }

                const pointer = orientation === "vertical" ? moveEvent.clientY : moveEvent.clientX;
                const delta = pointer - startPointer;
                const nextOffset = Math.min(Math.max(startThumbOffset + delta, 0), maxThumbOffset);

                if (orientation === "vertical") {
                    viewport.scrollTop = (nextOffset / maxThumbOffset) * maxScroll;
                } else {
                    viewport.scrollLeft = (nextOffset / maxThumbOffset) * maxScroll;
                }

                this.updateThumbs();
            };

            const onUp = () => {
                document.removeEventListener("pointermove", onMove);
                document.removeEventListener("pointerup", onUp);
            };

            document.addEventListener("pointermove", onMove);
            document.addEventListener("pointerup", onUp);
        },

        init() {
            this.$nextTick(() => {
                const viewport = this.$refs.viewport;

                if (!viewport) {
                    return;
                }

                const scheduleUpdate = () => {
                    this.updateThumbs();
                    requestAnimationFrame(() => this.updateThumbs());
                };

                scheduleUpdate();

                viewport.addEventListener("scroll", () => this.updateThumbs(), { passive: true });

                this.resizeObserver = new ResizeObserver(() => scheduleUpdate());
                this.resizeObserver.observe(viewport);

                if (viewport.firstElementChild) {
                    this.resizeObserver.observe(viewport.firstElementChild);
                }

                window.addEventListener("resize", () => scheduleUpdate(), { passive: true });

                this.onSidebarLayout = () => {
                    this.$nextTick(() => scheduleUpdate());
                };
                window.addEventListener("bladcn:sidebar-layout", this.onSidebarLayout);
            });
        },

        destroy() {
            this.resizeObserver?.disconnect();

            if (this.onSidebarLayout) {
                window.removeEventListener("bladcn:sidebar-layout", this.onSidebarLayout);
            }
        },
    }));
}
