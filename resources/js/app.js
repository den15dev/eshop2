import './bootstrap';

import menuOpeners  from './site/main/menu-opener-handler.js';
import dropdowns, { languageDropdown } from "./common/dropdowns";
import catalogMobile  from './site/main/catalog-mobile.js';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./site/main/catalog-desktop.js";
import search from './site/main/search.js';

import {initProductCarousels} from "./site/home.js";
import initCatalogFilters from "./site/catalog-filters.js";


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


// --------------- Catalog ------------------

initCatalogFilters();

// console.log(document.querySelectorAll('#catalogNavMobile .catalog-mobile-list > li').length);
