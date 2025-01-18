require('./bootstrap');

require('alpinejs');
import 'remixicon/fonts/remixicon.css'

import swal from 'sweetalert2';
window.Swal = swal;

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
window.Swiper = Swiper;

import { gsap } from "gsap";
import { Flip } from "gsap/Flip";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(Flip,ScrollTrigger,ScrollToPlugin);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.ScrollToPlugin = ScrollToPlugin;
