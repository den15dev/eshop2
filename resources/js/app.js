// import './bootstrap';

import menuOpeners from './site/main/menu-opener-handler.js';
import dropdowns, { localizationDropdowns } from "./common/dropdowns";
import tabs from "./common/tabs";
import modals from "./common/modals.js";
import catalogMobile  from './site/main/catalog-mobile.js';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./site/main/catalog-desktop.js";
import search from './site/main/search.js';
import auth from "./site/main/auth";

import { initProductCarousels } from "./site/home.js";
import initCatalogFilters from "./site/catalog-filters.js";
import initProductPage from "./site/product.js";


// --------------- Common ------------------

dropdowns();
tabs();
modals();

// --------------- Main ------------------

menuOpeners();
localizationDropdowns();
catalogMobile();
catalogDesktopRoot();
catalogDesktopDropdowns();
search();
auth();


// --------------- Home ------------------

initProductCarousels();

// --------------- Catalog ------------------

initCatalogFilters();

// --------------- Product ------------------

initProductPage();

// console.log(document.querySelectorAll('#catalogNavMobile .catalog-mobile-list > li').length);
