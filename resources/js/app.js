// import './bootstrap';

import { getTranslations } from "./common/global.js";
import menuOpeners from './site/main/menu-opener-handler.js';
import dropdowns, { localizationDropdowns } from "./common/dropdowns";
import tabs from "./common/tabs";
import modals from "./common/modals.js";
import catalogMobile  from './site/main/catalog-mobile.js';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./site/main/catalog-desktop.js";
import search from './site/main/search.js';
import auth, { handlePasswordEyeBtns } from "./site/main/auth";

import initQuantityButtons from "./site/components/quantity-buttons.js";

import { initProductCarousels } from "./site/home.js";
import initCatalogFilters from "./site/catalog-filters.js";
import initCatalogPreferences from "./site/catalog-prefs.js";
import initProductPage from "./site/product.js";
import initReviews from "./site/reviews.js";
import initCart from "./site/cart.js";
import initComparison from "./site/comparison.js";
import initFavorites from "./site/favorites.js";


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
handlePasswordEyeBtns();

// --------------- Components ------------------

initQuantityButtons();

// --------------- Home ------------------

initProductCarousels();

// --------------- Catalog ------------------

initCatalogFilters();
initCatalogPreferences();

// --------------- Product ------------------

initProductPage();

// --------------- Reviews ------------------

initReviews();

// --------------- Cart ------------------

initCart();

// --------------- Comparison ------------------

initComparison();

// --------------- Favorites ------------------

initFavorites();

// --------------- Get all client translations ------------------

getTranslations();
