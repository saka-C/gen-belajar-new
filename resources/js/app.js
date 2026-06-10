import './bootstrap';

// Import Swiper core and required modules
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Masukkan ke window agar bisa diakses di Blade
window.Swiper = Swiper;
window.SwiperModules = [Navigation, Pagination, Autoplay];
