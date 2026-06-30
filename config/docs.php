<?php

return [

    'excluded' => [
        'abstract',
    ],

    'groups' => [
        'Typography' => [
            'typography',
            'icon',
        ],
        'Layout' => [
            'card',
            'separator',
            'sidebar',
            'breadcrumb',
        ],
        'Form' => [
            'button',
            'input',
            'input-otp',
            'checkbox',
            'field',
            'label',
        ],
        'Data Display' => [
            'avatar',
            'badge',
        ],
        'Feedback' => [
            'alert',
            'sonner',
        ],
        'Overlay' => [
            'dialog',
            'alert-dialog',
            'dropdown-menu',
        ],
    ],

    'descriptions' => [
        'alert' => 'Displays a callout for user attention.',
        'alert-dialog' => 'A modal dialog that interrupts the user with important content and expects a response.',
        'avatar' => 'An image element with a fallback for representing the user.',
        'badge' => 'Displays a badge or a component that looks like a badge.',
        'breadcrumb' => 'Displays the path to the current resource using a hierarchy of links.',
        'button' => 'Displays a button or a component that looks like a button.',
        'card' => 'Displays a card with header, content, and footer.',
        'checkbox' => 'A control that allows the user to toggle between checked and not checked.',
        'dialog' => 'A window overlaid on either the primary window or another dialog window.',
        'dropdown-menu' => 'Displays a menu to the user triggered by a button.',
        'field' => 'Combine labels, controls, and help text for form fields.',
        'icon' => 'Lucide icons via the blade-lucide-icons package.',
        'input' => 'Displays a form input field or a component that looks like an input field.',
        'input-otp' => 'Accessible one-time password component with copy paste support.',
        'label' => 'Renders an accessible label associated with controls.',
        'separator' => 'Visually or semantically separates content.',
        'sidebar' => 'A composable, themeable and customizable sidebar.',
        'sonner' => 'An opinionated toast component for Laravel.',
        'typography' => 'Styles for headings, paragraphs, lists, and other text elements.',
    ],

];
