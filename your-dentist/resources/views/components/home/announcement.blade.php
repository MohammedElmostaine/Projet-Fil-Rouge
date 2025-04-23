<!-- filepath: c:\Users\elmos\Desktop\Ycode\Projet-Fil-Rouge\your-dentist\resources\views\components\home\announcement.blade.php -->
<div class="bg-primary-700 text-white py-2 px-4 text-center relative">
    <div class="container mx-auto">
        <p class="text-sm">New Patient Special: Free Consultation & X-rays | <a href="#book-appointment" class="underline hover:text-primary-200">Book Now</a></p>
        <button id="close-banner" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-primary-200">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<script>
    // Announcement Banner
    document.addEventListener('DOMContentLoaded', function() {
        const closeBanner = document.getElementById('close-banner');
        if (closeBanner) {
            const banner = closeBanner.parentElement.parentElement;
            closeBanner.addEventListener('click', () => {
                banner.style.display = 'none';
            });
        }
    });
</script>