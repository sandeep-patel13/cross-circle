<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <style>
        button,
        input[type="radio"],
        label {
            cursor: pointer !important;
        }

        .fake-disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        /* Custom sidebar gradient background */
        .sidebar-gradient {
            background: linear-gradient(180deg, 
                rgba(0, 0, 0, 1) 0%, 
                rgba(127, 29, 29, 0.15) 25%,
                rgba(185, 28, 28, 0.1) 50%,
                rgba(127, 29, 29, 0.15) 75%,
                rgba(0, 0, 0, 1) 100%
            );
            position: relative;
        }

        .sidebar-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 30%, rgba(220, 38, 38, 0.08) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Global text color theme */
        body {
            color: #e5e7eb; /* Light gray for better readability */
        }

        h1, h2, h3, h4, h5, h6 {
            color: #ffffff; /* White for headings */
        }

        p, span, div, label {
            color: #d1d5db; /* Slightly lighter gray for regular text */
        }

        a {
            color: #fca5a5; /* Light red for links */
        }

        a:hover {
            color: #ef4444; /* Brighter red on hover */
        }

        /* Input and form element text colors */
        input, textarea, select {
            color: #ffffff;
        }

        input::placeholder, textarea::placeholder {
            color: #9ca3af; /* Medium gray for placeholders */
        }

        /* Button text colors */
        button {
            color: #ffffff;
        }

        /* Table text colors */
        table, th, td {
            color: #d1d5db;
        }

        /* Alert and notification text */
        .text-muted, .text-secondary {
            color: #9ca3af !important;
        }

        .text-primary {
            color: #ef4444 !important; /* Red for primary text */
        }

        .text-success {
            color: #fca5a5 !important; /* Light red instead of green */
        }

        .text-danger {
            color: #dc2626 !important; /* Dark red for danger */
        }

        .text-warning {
            color: #f87171 !important; /* Red-orange for warnings */
        }

        .text-info {
            color: #fca5a5 !important; /* Light red for info */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
</head>

<body class="min-h-screen bg-black dark:bg-black">
    <flux:sidebar sticky stashable class="sidebar-gradient border-e border-red-900/50 dark:border-red-900/50">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('dashboard') }}" wire:navigate>
                {{ __('Dashboard') }}
            </flux:navlist.item>
            <flux:navlist.item class="mt-3" icon="puzzle-piece" href="{{ route('play-game') }}" wire:navigate>
                {{ __('Play Game') }}
            </flux:navlist.item>
            <flux:navlist.item class="mt-3" icon="bolt" href="{{ route('play-online') }}" wire:navigate>
                {{ __('Play Online') }}
            </flux:navlist.item>
            <flux:navlist.item class="mt-3" icon="clipboard-document-check" href="{{ route('games-report') }}" wire:navigate>
                {{ __('Games Report') }}
            </flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-red-900 text-white dark:bg-red-900 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-red-900 text-white dark:bg-red-900 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-toast', (data) => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    },
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            Echo.private("invite.{{ auth()->user()->id }}")
                .listen('.play-event', (e) => {
                    Swal.fire({
                        title: 'Game Invitation',
                        text: `User ${e.fromUserName} challanged you to play!`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Accept',
                        cancelButtonText: 'Decline'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('game-play-invitation-accepted', {
                                gameSessionId: e.gameSession.id
                            });
                        } else {
                            Livewire.dispatch('game-play-invitation-rejected', {
                                gameSessionId: e.gameSession.id
                            });
                        }
                    });
                })
                .listen('.invitation-accepted', (e) => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        title: 'Invitation Accepted!',
                        text: `User ${e.gameSession.invitee.name} accepted your invitation!`,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        },
                    })
                    .then(() => {
                        console.log(e);
                        window.location.href = "{{ url('request-accepted') }}/" + e.gameSession.id;
                    });
                })
                .listen('.invitation-rejected', (e) => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        title: 'Invitation Rejected!',
                        text: `User ${e.invitee_name} rejected your invitation!`,
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        },
                    });
                });
        });
    </script>

    @fluxScripts
</body>

</html>