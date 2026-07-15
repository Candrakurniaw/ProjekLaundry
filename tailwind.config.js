/* ═══════════════════════════════════════════════
   Tailwind Config - PoS Laundry
   ═══════════════════════════════════════════════ */

/** @type {import('tailwindcss').Config} */
export default {
    
    darkMode: 'class',
    
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    
    theme: {
        extend: {
            
            // ═══ COLORS ═══
            colors: {
                
                // ─── Primary ───
                primary: {
                    DEFAULT: '#006738',
                    container: '#1e824c',
                    fixed: '#98f7b5',
                    'fixed-dim': '#7cda9b',
                },
                'on-primary': {
                    DEFAULT: '#ffffff',
                    container: '#e5ffe8',
                    fixed: '#00210e',
                    'fixed-variant': '#00522b',
                },
                
                // ─── Secondary ───
                secondary: {
                    DEFAULT: '#006d37',
                    container: '#6bfe9c',
                    fixed: '#6bfe9c',
                    'fixed-dim': '#4ae183',
                },
                'on-secondary': {
                    DEFAULT: '#ffffff',
                    container: '#00743a',
                    fixed: '#00210c',
                    'fixed-variant': '#005228',
                },
                
                // ─── Tertiary ───
                tertiary: {
                    DEFAULT: '#005e90',
                    container: '#0078b5',
                    fixed: '#cce5ff',
                    'fixed-dim': '#92ccff',
                },
                'on-tertiary': {
                    DEFAULT: '#ffffff',
                    container: '#f5f8ff',
                    fixed: '#001d31',
                    'fixed-variant': '#004b73',
                },
                
                // ─── Surface ───
                surface: {
                    DEFAULT: '#f7f9fb',
                    dim: '#d8dadc',
                    bright: '#f7f9fb',
                    variant: '#e0e3e5',
                    container: {
                        DEFAULT: '#eceef0',
                        low: '#f2f4f6',
                        lowest: '#ffffff',
                        high: '#e6e8ea',
                        highest: '#e0e3e5',
                    },
                    tint: '#006d3b',
                },
                'on-surface': {
                    DEFAULT: '#191c1e',
                    variant: '#3f4940',
                },
                
                // ─── Background ───
                background: '#f7f9fb',
                'on-background': '#191c1e',
                
                // ─── Inverse ───
                'inverse-surface': '#2d3133',
                'inverse-on-surface': '#eff1f3',
                'inverse-primary': '#7cda9b',
                
                // ─── Error ───
                error: {
                    DEFAULT: '#ba1a1a',
                    container: '#ffdad6',
                },
                'on-error': {
                    DEFAULT: '#ffffff',
                    container: '#93000a',
                },
                
                // ─── Outline ───
                outline: {
                    DEFAULT: '#6f7a70',
                    variant: '#becabe',
                },
                
            },
            
            // ═══ BORDER RADIUS ═══
            borderRadius: {
                DEFAULT: '0.25rem',
                lg: '0.5rem',
                xl: '0.75rem',
                full: '9999px',
            },
            
            // ═══ SPACING ═══
            spacing: {
                unit: '4px',
                'container-padding': '16px',
                'card-gap': '12px',
                'sidebar-width': '0px',
                gutter: '16px',
                'input-height': '48px',
            },
            
            // ═══ FONT FAMILY ═══
            fontFamily: {
                'label-bold': ['Inter', 'sans-serif'],
                'body-sm': ['Inter', 'sans-serif'],
                'body-base': ['Inter', 'sans-serif'],
                'title-sm': ['Inter', 'sans-serif'],
                'headline-md': ['Inter', 'sans-serif'],
                'headline-md-mobile': ['Inter', 'sans-serif'],
                'display-lg': ['Inter', 'sans-serif'],
            },
            
            // ═══ FONT SIZE ═══
            fontSize: {
                'label-bold': ['12px', { lineHeight: '16px', fontWeight: '600' }],
                'body-sm': ['12px', { lineHeight: '18px', fontWeight: '400' }],
                'body-base': ['14px', { lineHeight: '20px', fontWeight: '400' }],
                'title-sm': ['16px', { lineHeight: '22px', fontWeight: '600' }],
                'headline-md': ['20px', { lineHeight: '28px', letterSpacing: '-0.01em', fontWeight: '600' }],
                'headline-md-mobile': ['20px', { lineHeight: '28px', fontWeight: '600' }],
                'display-lg': ['24px', { lineHeight: '32px', letterSpacing: '-0.02em', fontWeight: '700' }],
            },
            
        },
    },
    
    plugins: [],
    
};