import {getSiteTranslations, setTimezoneCookie} from "./common/global.js";
import dropdowns, { localizationDropdowns } from "./common/dropdowns";
import tabs from "./common/tabs";
import modals from "./common/modals.js";
import initPagination from "./common/pagination.js";

import initOpeners from './site/main/menu-openers.js';
import catalogMobile from './site/main/catalog-mobile.js';
import { catalogDesktopRoot, catalogDesktopDropdowns } from "./site/main/catalog-desktop.js";
import search from './site/main/search.js';
import headerEmptyBubbles from './site/main/header-empty-bubbles.js';
import showDemoNote from './site/main/demo-note.js';

import initAuth from "./site/components/auth/_init.js";
import initCartComponent from "./site/components/cart/_init.js";
import initComparisonComponent from "./site/components/comparison/_init.js";
import initCarousels from "./site/components/swiper-carousels.js";
import initReviewReactions from "./site/components/review-reactions.js";

import initCatalogFilters from "./site/pages/catalog-filters.js";
import initCatalogPreferences from "./site/pages/catalog-prefs.js";
import initProductPage from "./site/pages/product.js";
import initReviews from "./site/pages/reviews.js";
import initCart from "./site/pages/cart.js";
import initComparison from "./site/pages/comparison.js";
import initFavorites from "./site/components/favorites.js";
import initNotifications from "./site/pages/user-notifications.js";
import initShops from "./site/pages/shops.js";


// --------------- Common ------------------

setTimezoneCookie();
dropdowns();
tabs();
modals();
initPagination();

// --------------- Main ------------------

initOpeners();
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

// --------------- Get client translations ------------------

getSiteTranslations();

// -------------------- Other ------------------

showDemoNote();
