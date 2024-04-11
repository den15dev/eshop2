import { getTranslations } from "./common/global.js";
import menuOpeners from './site/main/menu-opener-handler.js';
import dropdowns, { localizationDropdowns } from "./common/dropdowns";
import tabs from "./common/tabs";
import modals from "./common/modals.js";
import initPagination from "./common/pagination.js";

import catalogMobile from './site/main/catalog-mobile.js';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./site/main/catalog-desktop.js";
import search from './site/main/search.js';
import headerEmptyBubbles from './site/main/header-empty-bubbles.js'

import initAuth from "./site/components/auth/_init.js"
import initCartComponent from "./site/components/cart/_init.js"
import initComparisonComponent from "./site/components/comparison/_init.js"
import initCarousels from "./site/components/swiper-carousels.js";
import initReviewReactions from "./site/components/review-reactions.js"

import initCatalogFilters from "./site/pages/catalog-filters.js";
import initCatalogPreferences from "./site/pages/catalog-prefs.js";
import initProductPage from "./site/pages/product.js";
import initReviews from "./site/pages/reviews.js";
import initCart from "./site/pages/cart.js";
import initComparison from "./site/pages/comparison.js";
import initFavorites from "./site/components/favorites.js";
import initNotifications from "./site/pages/user-notifications.js"
import initShops from "./site/pages/shops.js"


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
headerEmptyBubbles();

// --------------- Components ------------------

initAuth();
initCartComponent();
initComparisonComponent();
initCarousels();
initReviewReactions();

// --------------- Pages ------------------

initCatalogFilters();
initCatalogPreferences();
initProductPage();
initReviews();
initCart();
initComparison();
initFavorites();
initNotifications();
initShops();

// --------------- Get all client translations ------------------

getTranslations();
