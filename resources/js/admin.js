import { adjustTextAreaHeights, getAdminTranslations } from "./common/global.js";
import initDropdowns, { localizationDropdowns } from "./common/dropdowns";
import modals from "./common/modals.js";
import initPagination from "./common/pagination.js";

import initOpeners from './admin/main/menu-openers.js';

import initIndexTable from "./admin/components/index-table.js";

import initProductIndex from "./admin/pages/product-index.js"
import initProductEdit from "./admin/pages/product-edit.js"
import initSkuEdit from "./admin/pages/sku-edit.js"

// --------------- Common ------------------

initDropdowns();
modals();
initPagination();
adjustTextAreaHeights();

// --------------- Components ------------------

initIndexTable();

// --------------- Main ------------------

localizationDropdowns();
initOpeners();


// --------------- Products ------------------

initProductIndex();
initProductEdit();
initSkuEdit();


// --------------- Get client translations ------------------

getAdminTranslations();