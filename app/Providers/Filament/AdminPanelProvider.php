<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('ANDRA JB')
            ->brandLogo(fn () => view('filament.brand-logo'))
            ->brandLogoHeight('2.5rem')
            ->font(
                'Inter',
                url: asset('fonts/filament/filament/inter/index.css'),
                provider: \Filament\FontProviders\LocalFontProvider::class,
            )
            ->colors([
                'primary' => Color::Indigo,
                'gray' => Color::Slate,
            ])
            ->navigationGroups([
                'Etalase Toko',
                'Penjualan',
                'Pengaturan Akses',
            ])
            ->renderHook('panels::head.end', fn () => new \Illuminate\Support\HtmlString('
                <style>
                    .brand-title-text { color: #0f172a; }
                    .dark .brand-title-text { color: #f8fafc !important; }
                    .footer-brand-text { color: #334155; }
                    .dark .footer-brand-text { color: #cbd5e1 !important; }
                    .fi-logo { display: inline-flex !important; align-items: center !important; }
                    .fi-logo svg, .fi-logo img { max-height: 2.5rem !important; }
                    /* Super Clear & Prominent Admin Notifications */
                    .fi-no {
                        z-index: 99999 !important;
                    }
                    .fi-no-notification {
                        border-radius: 1rem !important;
                        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
                        border: 2px solid rgba(16, 185, 129, 0.35) !important;
                        backdrop-filter: blur(8px) !important;
                    }
                    .fi-no-notification-title {
                        font-weight: 800 !important;
                        font-size: 0.95rem !important;
                    }
                    .fi-no-notification-body {
                        font-size: 0.85rem !important;
                        margin-top: 0.2rem !important;
                        line-height: 1.4 !important;
                    }
                    /* Mobile Admin Responsiveness & Touch Optimization */
                    @media (max-width: 768px) {
                        .fi-topbar { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                        .fi-main-ctn { padding-left: 0.75rem !important; padding-right: 0.75rem !important; padding-bottom: 2rem !important; }
                        .fi-ta-content { overflow-x: auto !important; -webkit-overflow-scrolling: touch !important; }
                        .fi-ta-table { min-width: 100% !important; }
                        .fi-btn { min-height: 2.5rem !important; touch-action: manipulation !important; }
                        .fi-input { font-size: 1rem !important; }
                        .fi-no {
                            top: 1rem !important;
                            right: 0.75rem !important;
                            left: 0.75rem !important;
                            max-width: calc(100vw - 1.5rem) !important;
                        }
                    }
                </style>
            '))
            ->renderHook('panels::footer', fn () => view('filament.custom-footer'))
            ->sidebarCollapsibleOnDesktop()
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make('Buka Website Toko')
                    ->url('/', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->group('Etalase Toko')
                    ->sort(99),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\QuickAdminGuide::class,
                \App\Filament\Widgets\StatsOverview::class,
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
