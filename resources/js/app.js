// import './bootstrap';

import { getTranslations } from "./common/global.js";
import menuOpeners from './site/main/menu-opener-handler.js';
import dropdowns, { localizationDropdowns } from "./common/dropdowns";
import tabs from "./common/tabs";
import modals from "./common/modals.js";
import initPagination from "./common/pagination.js";

import catalogMobile  from './site/main/catalog-mobile.js';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./site/main/catalog-desktop.js";
import search from './site/main/search.js';
import auth, { handlePasswordEyeBtns } from "./site/main/auth";

import { initProductCarousels } from "./site/home.js";
import initCatalogFilters from "./site/catalog-filters.js";
import initCatalogPreferences from "./site/catalog-prefs.js";
import initProductPage from "./site/product.js";
import initReviews from "./site/reviews.js";
import initCartHandler from "./site/cart-handler.js";
import initCartPage from "./site/cart.js";
import initComparison from "./site/comparison.js";
import initFavorites from "./site/favorites.js";
import initNotifications from "./site/user-notifications.js"
import initShops from "./site/shops.js"


// --------------- Common ------------------

dropdowns();
tabs();
modals();
initPagination();

// --------------- Main ------------------

menuOpeners();
localizationDropdowns();
catalogMobile();
catalogDesktopRoot();
catalogDesktopDropdowns();
search();
auth();
handlePasswordEyeBtns();

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

initCartHandler();
initCartPage();

// --------------- Comparison ------------------

initComparison();

// --------------- Favorites ------------------

initFavorites();

// --------------- User notifications ------------------

initNotifications();

// --------------- User notifications ------------------

initShops();

// --------------- Get all client translations ------------------

getTranslations();

