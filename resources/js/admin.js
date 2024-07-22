import {adjustTextAreaHeights, getAdminTranslations, showSubmit403Messages} from "./common/global.js";
import initDropdowns, { localizationDropdowns } from "./common/dropdowns";
import modals from "./common/modals.js";
import initPagination from "./common/pagination.js";

import initOpeners from './admin/main/menu-openers.js';

import initIndexTable from "./admin/components/index-table.js";

import initProductIndex from "./admin/pages/product-index.js";
import initProductEdit from "./admin/pages/product-edit.js";
import initSkuEdit from "./admin/pages/sku-edit.js";
import initSkuCreate from "./admin/pages/sku-create.js";
import initCategoryIndex from "./admin/pages/category-index.js";
import initCategoryEdit from "./admin/pages/category-edit.js";
import initBrandEdit from "./admin/pages/brand-edit.js";
import initPromoEdit from "./admin/pages/promo-edit.js";
import initOrderIndex from "./admin/pages/order-index.js";
import initOrderEdit from "./admin/pages/order-edit.js";
import initUserIndex from "./admin/pages/user-index.js";
import initUserEdit from "./admin/pages/user-edit.js";
import initReviewEdit from "./admin/pages/review-edit.js";

// --------------- Common ------------------

initDropdowns();
modals();
initPagination();
adjustTextAreaHeights();
showSubmit403Messages();

// --------------- Components ------------------

initIndexTable();

// --------------- Main ------------------

localizationDropdowns();
initOpeners();


// --------------- Pages ------------------

initProductIndex();
initProductEdit();
initSkuEdit();
initSkuCreate();
initCategoryIndex();
initCategoryEdit();
initBrandEdit();
initPromoEdit();
initOrderIndex();
initOrderEdit();
initUserIndex();
initUserEdit();
initReviewEdit();


// --------------- Get client translations ------------------

getAdminTranslations();
