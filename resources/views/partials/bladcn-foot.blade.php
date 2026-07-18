{{-- FOUC: backup for legacy localStorage-only prefs before cookie SSR on the next reload. --}}
<script>
    (function applySidebarFootGuard(attempt) {
        try {
            if (window.bladcnSidebarLayout?.applyFootGuard()) {
                return;
            }

            if (attempt < 2) {
                requestAnimationFrame(() => applySidebarFootGuard(attempt + 1));
            }
        } catch {}
    })(0);
</script>

@stack('bladcn-scripts')
