import './bootstrap';

import menuOpeners  from './common/menu-opener-handler';
import dropdowns, { languageDropdown } from "./common/dropdowns";
import catalogMobile  from './common/catalog-mobile';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./common/catalog-desktop";
import search from './common/search';

import {promoSwiper, initProductCarousels} from "./pages/home";


// --------------- Common ------------------

menuOpeners();
dropdowns();
languageDropdown();
catalogMobile();
catalogDesktopRoot();
catalogDesktopDropdowns();
search();


// --------------- Home ------------------

initProductCarousels();

// console.log(document.querySelectorAll('#catalogNavMobile .catalog-mobile-list > li').length);