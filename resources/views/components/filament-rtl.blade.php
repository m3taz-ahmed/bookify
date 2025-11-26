@if(app()->getLocale() === 'ar')
<style>
    [dir="rtl"] .fi-sidebar-nav {
        direction: rtl;
        text-align: right;
    }
    
    [dir="rtl"] .fi-topbar {
        direction: rtl;
    }
    
    [dir="rtl"] .fi-main {
        direction: rtl;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.documentElement.setAttribute('dir', 'rtl');
        document.documentElement.setAttribute('lang', 'ar');
    });
</script>
@else
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.documentElement.setAttribute('dir', 'ltr');
        document.documentElement.setAttribute('lang', 'en');
    });
</script>
@endif