<template>
    <div>
        <!-- Loader start -->
        <div class="loader-div" v-show="isLoading">
            <div class="loder-inner-div">
                <div class="loader"></div>
            </div>
        </div>
        <!-- Loader end -->

        <!-- Work Types select start -->
        <div class="h-36 mt-10">
            <span class="input-label pl-2">{{ worktypesplaceholder }}*</span>
            <div class="select-menu-work-type" :class="{ active: isActiveWorkTypes }">
                <div class="select-btn-work-type" @click="toggleMenuWorkTypes">
                    <span class="sBtn-text-work-type">{{ selectedWorkTypeName }}</span>
                    <svg role="img" viewBox="0 0 512 512">
                        <path
                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                    </svg>
                </div>
            
                <ul class="options-work-type">
                    <li class="option-work-type">
                        <input type="text" v-model="searchQueryWorkType" :placeholder="searchPlaceholder + '...'" class="quantity-input">
                    </li>
                    <li v-for="option in workTypes" :key="option.id" class="option-work-type" v-show="workTypesSearch(option)" @click="selectOptionWorkType(option)">
                        <span class="option-text-work-type">{{ option.name[lang] }}</span>
                    </li>
                </ul>
            </div>

            <input type="hidden" name="worktype" :value="selectedWorkTypeId" />
        </div>

        <!-- Work Types select end -->

        <!-- Category select start -->

        <div class="h-36 categoryDivScrollMargin" ref="categoryDiv" v-show="showCategory" >
            <span class="input-label pl-2">{{ categoryplaceholder }}*</span>
            <div class="select-menu-category" :class="{ active: isActiveCategory }">
                <div class="select-btn-category" @click="toggleMenuCategory">
                    <span class="sBtn-text-category">{{ selectedCategoryName }}</span>
                    <svg role="img" viewBox="0 0 512 512">
                        <path
                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                    </svg>
                </div>
            
                <ul class="options-category">
                    <li class="option-category">
                        <input type="text" v-model="searchQueryCategory" :placeholder="searchPlaceholder + '...'" class="quantity-input">
                    </li>
                    <li v-if="categories.length === 0" class="option-category">
                        <span class="option-text-category">{{ noCategory }}</span>
                    </li>
                    <li v-else v-for="option in categories" :key="option.id" class="option-category" v-show="categorySearch(option)" @click="selectOptionCategory(option)">
                        <span class="option-text-category">{{ option.name[lang] }}</span>
                    </li>
                </ul>
            </div>
            <input type="hidden" name="category" :value="selectedCategoryId" />
        </div>
        
        <!-- Category select end -->

        <!-- Subcategory select start -->

        <div class="h-36 subCategoryDivScrollMargin" ref="subCategoryDiv" v-show="showSubcategory" >
            <span class="input-label pl-2">{{ subcategoryplaceholder }}*</span>
            <div class="select-menu-subcategory" :class="{ active: isActiveSubcategory }">
                <div class="select-btn-subcategory" @click="toggleMenuSubcategory">
                    <span class="sBtn-text-subcategory">{{ selectedSubcategoryName }}</span>
                    <svg role="img" viewBox="0 0 512 512">
                        <path
                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                    </svg>
                </div>
            
                <ul class="options-subcategory">
                    <li class="option-subcategory">
                        <input type="text" v-model="searchQuerySubcategory" :placeholder="searchPlaceholder + '...'" class="quantity-input">
                    </li>
                    <li v-if="categories.length === 0" class="option-subcategory">
                        <span class="option-text-subcategory">{{ noCategory }}</span>
                    </li>
                    <li v-else v-for="option in subcategories" :key="option.id" class="option-subcategory" v-show="subcategorySearch(option)" @click="selectOptionSubcategory(option)">
                        <span class="option-text-subcategory">{{ option.name[lang] }}</span>
                    </li>
                </ul>
            </div>
            <input type="hidden" name="subcategory" :value="selectedSubcategoryId" />
        </div>
        
        <!-- Subcategory select end -->

        <!-- Pozicija select start -->

        <div v-show="showPozicija">
            <div class="pozicijaDivScrollMargin" ref="pozicijaDiv" >
                <span class="input-label pl-2">{{ pozicijaplaceholder }}*</span>
                <div class="select-menu-pozicija" :class="{ active: isActivePozicija }">
                    <div class="select-btn-pozicija" @click="toggleMenuPozicija">
                        <span class="sBtn-text-pozicija">{{ selectedPozicijaName }}</span>
                        <svg role="img" viewBox="0 0 512 512">
                            <path
                            d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                        </svg>
                    </div>
                
                    <ul class="options-pozicija">
                        <li class="option-pozicija">
                            <input type="text" v-model="searchQueryPozicija" :placeholder="searchPlaceholder + '...'" class="quantity-input">
                        </li>
                        <li v-for="option in pozicije" :key="option.id" class="option-pozicija" v-show="pozicijaSearch(option)" @click="selectOptionPozicija(option)">
                            <span class="option-text-pozicija">{{ option.title[lang] }}</span>
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="pozicija" :value="selectedPozicijaId" />
            </div>

            <div v-show="selectedPozicijaId" class="pozicijaQtyDivScrollMargin" ref="pozicijaQtyDiv" >

                <div class="flex w-full flex-col">
                    <div class="w-full flex justify-end">
                        <button type="button" class="del-btn my-3 w-min" @click="deletePozicijaDes">
                            {{ desDeleteBtn }}
                        </button>
                    </div>
                    <textarea cols="50" rows="6" name="edit_des" id="editField" :value="selectedPozicijaDescription"></textarea>
                </div>
                
                <div class="quantity-div">
                    <div class="mt-10 mb-2">
                        <span>{{ materialPriceTitle }}*</span>
                    </div>
                    <p class="py-3">
                        <input type="radio" id="material" name="radioButton" v-model="radioBtn" value="1">
                        <label for="material">{{ materialPriceWithMaterial }}</label>
                    </p>
                    <p class="py-3">
                        <input type="radio" id="service" name="radioButton" v-model="radioBtn" value="2">
                        <label for="service">{{ mterialPriceWithoutMaterial }}</label>
                    </p>
                    <div id="quantity-text" class="mt-10">
                        {{ unitQtyTitle }} ( {{ unitName }} )*
                    </div>

                    <input type="number" name="quantity" ref="qtyInput" class="quantity-input mt-3 mb-1">

                    <div class="mt-10">
                        <span>{{ priceTitle }}*</span>
                    </div>

                    <input type="number" name="price" ref="priceInput" step=".01" min="1"
                        class="quantity-input mt-3 mb-1">

                </div>

                <div class="flex w-full justify-center mt-5">
                    <div class="flex">
                        <button class="finish-btn my-3">{{ finishBtnText }}</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pozicija select end -->
    </div>
</template>

<script>
    export default {
        props: [
            'worktypes',
            'worktypesplaceholder',
            'categoryplaceholder',
            'nocategory',
            'subcategoryplaceholder',
            'pozicijaplaceholder',
            'materialpricetitle',
            'materialpricewithmaterial',
            'materialpricewithnomaterial',
            'pricetitle',
            'desdeletebtn',
            'unitqtytitle',
            'finishbtntext',
            'searchtext',
            'locale',
            'url',
            'workerid',
        ],

        data() {
            return { 
                //Must have varibles
                lang: this.locale,
                url: this.url,
                workerId: this.workerid,
                isLoading: false,
                finishBtnText: this.finishbtntext,
                radioBtn: '',
                searchQueryWorkType: '',
                searchQueryCategory:'',
                searchQuerySubcategory:'',
                searchQueryPozicija:'',
                searchPlaceholder: this.searchtext,

                //Work types varibles
                isActiveWorkTypes: false,
                selectedWorkTypeName: this.worktypesplaceholder,
                selectedWorkTypeId: '',
                workTypes: this.worktypes,

                //Category varibles
                isActiveCategory: false,
                showCategory: false,
                categories: {},
                selectedCategoryName: this.categoryplaceholder,
                selectedCategoryId: '',
                noCategory: this.nocategory,

                //Subcategory varibles
                isActiveSubcategory: false,
                showSubcategory: false,
                subcategories: {},
                selectedSubcategoryName: this.subcategoryplaceholder,
                selectedSubcategoryId: '',

                //Pozicije varibles
                isActivePozicija: false,
                showPozicija: false,
                pozicije: {},
                selectedPozicijaName: this.pozicijaplaceholder,
                selectedPozicijaId: '',
                selectedPozicijaDescription: '',
                selectedPozicijaUnit: '',
                materialPriceTitle: this.materialpricetitle,
                materialPriceWithMaterial: this.materialpricewithmaterial,
                mterialPriceWithoutMaterial: this.materialpricewithnomaterial,
                priceTitle: this.pricetitle,
                desDeleteBtn: this.desdeletebtn,
                unitQtyTitle: this.unitqtytitle,
                unitName: '',
            }
        },

        computed: {
        },

        methods: {
            //methods for the work types start
            toggleMenuWorkTypes() {
                //show hide the dropsown for work types
                this.isActiveWorkTypes = !this.isActiveWorkTypes;
                this.isActiveCategory = false;
            },

            workTypesSearch(option) {
                const searchQuery = this.searchQueryWorkType.toLowerCase().trim();
                const optionName = option.name[this.lang].toLowerCase();
                return optionName.includes(searchQuery);
            },

            selectOptionWorkType(option) {
                //set value for work types in the dropdown and for the hidden input
                this.selectedWorkTypeName = option.name[this.lang];
                this.selectedWorkTypeId = option.id;
                this.isActiveWorkTypes = false;
                
                //reset category values
                this.selectedCategoryName = this.categoryplaceholder;
                this.selectedCategoryId = '';

                //reset subcategory values
                this.selectedSubcategoryName = this.subcategoryplaceholder;
                this.selectedSubcategoryId = '';
                this.showSubcategory = false;

                //reset pozicija values
                this.selectedPozicijaName = this.pozicijaplaceholder;
                this.selectedPozicijaId = '';
                this.showPozicija = false;
                this.radioBtn = null;
                this.$refs.qtyInput.value = '';
                this.$refs.priceInput.value = '';

                //generate the URL for the api call
                var categoryUrl = this.url + "/" + this.lang + "/contractor/get-categories/" + this.selectedWorkTypeId + "/" + this.workerId;

                //show the loader until the response come
                this.isLoading = true;

                //get categories from the backend
                axios.get(categoryUrl)
                    .then(response => {
                        this.categories = response.data;

                        //show the category dropdown div
                        this.showCategory = true;

                        //hide the loader
                        this.isLoading = false;

                        setTimeout(() => {
                            this.$refs.categoryDiv.scrollIntoView({ behavior: 'smooth' }); 
                        }, 100);
                });
            },

            //methods for the work types end

            //methods for the categories start

            toggleMenuCategory() {
                //show hide the dropsown for category
                this.isActiveCategory = !this.isActiveCategory;
                this.isActiveSubcategory = false;
                this.isActiveWorkTypes = false;
                this.isActivePozicija = false;
            },

            categorySearch(option) {
                const searchQuery = this.searchQueryCategory.toLowerCase().trim();
                const optionName = option.name[this.lang].toLowerCase();
                return optionName.includes(searchQuery);
            },

            selectOptionCategory(option) {
                //set value for category in the dropdown and for the hidden input
                this.selectedCategoryName = option.name[this.lang];
                this.selectedCategoryId = option.id;
                this.isActiveCategory = false;

                //reset subcategory values
                this.selectedSubcategoryName = this.subcategoryplaceholder;
                this.selectedSubcategoryId = '';
                this.showSubcategory = false;
                
                //reset pozicija values
                this.selectedPozicijaName = this.pozicijaplaceholder;
                this.selectedPozicijaId = '';
                this.showPozicija = false;
                this.radioBtn = null;
                this.$refs.qtyInput.value = '';
                this.$refs.priceInput.value = '';

                //generate the URL for the api call
                var subcategoryUrl = this.url + "/" + this.lang + "/contractor/get-subcategories/" + this.selectedCategoryId + "/" + this.workerId;

                //show the loader until the response come
                this.isLoading = true;

                //get subcategories from the backend
                axios.get(subcategoryUrl)
                    .then(response => {
                        this.subcategories = response.data;

                        //show the category dropdown div
                        this.showSubcategory = true;

                        //hide the loader
                        this.isLoading = false;

                        setTimeout(() => {
                            this.$refs.subCategoryDiv.scrollIntoView({ behavior: 'smooth' });
                        }, 100);
                });
            },

            //methods for the categories end

            //methods for the subcategories start

             toggleMenuSubcategory() {
                //show hide the dropsown for subcategory
                this.isActiveSubcategory = !this.isActiveSubcategory;
                this.isActiveCategory = false;
                this.isActivePozicija = false;
                this.isActiveWorkTypes = false;
            },

            subcategorySearch(option) {
                const searchQuery = this.searchQuerySubcategory.toLowerCase().trim();
                const optionName = option.name[this.lang].toLowerCase();
                return optionName.includes(searchQuery);
            },

            selectOptionSubcategory(option) {
                //set value for subcategory in the dropdown and for the hidden input
                this.selectedSubcategoryName = option.name[this.lang];
                this.selectedSubcategoryId = option.id;
                this.isActiveSubcategory = false;

                //reset pozicija values
                this.selectedPozicijaName = this.pozicijaplaceholder;
                this.selectedPozicijaId = '';
                this.showPozicija = false;
                this.radioBtn = null;
                this.$refs.qtyInput.value = '';
                this.$refs.priceInput.value = '';

                //generate the URL for the api call
                var pozicijaUrl = this.url + "/" + this.lang + "/contractor/get-pozicija/" + this.selectedSubcategoryId + "/" + this.workerId;

                //show the loader until the response come
                this.isLoading = true;

                //get pozicija from the backend
                axios.get(pozicijaUrl)
                    .then(response => {
                        this.pozicije = response.data;

                        //show the category dropdown div
                        this.showPozicija = true;

                        //hide the loader
                        this.isLoading = false;

                        setTimeout(() => {
                            this.$refs.pozicijaDiv.scrollIntoView({ behavior: 'smooth' });
                        }, 100);
                });
            },

            //methods for the subcategories end

            //methods for the pozicija start

            toggleMenuPozicija() {
                //show hide the dropsown for pozicija
                this.isActivePozicija = !this.isActivePozicija;
                this.isActiveSubcategory = false;
                this.isActiveWorkTypes = false;
                this.isActiveCategory = false;
            },

            pozicijaSearch(option) {
                const searchQuery = this.searchQueryPozicija.toLowerCase().trim();
                const optionName = option.title[this.lang].toLowerCase();
                return optionName.includes(searchQuery);
            },

            deletePozicijaDes() {
                this.selectedPozicijaDescription = '';
            },

            selectOptionPozicija(option) {
                //set value for pozicija in the dropdown and for the hidden input
                this.selectedPozicijaName = option.title[this.lang];
                this.selectedPozicijaDescription = option.description[this.lang];
                this.selectedPozicijaId = option.id;
                this.isActivePozicija = false;
                this.unitName = option.name[this.lang];

                setTimeout(() => {
                    this.$refs.pozicijaQtyDiv.scrollIntoView({ behavior: 'smooth' }); 
                }, 100);
            },

            //methods for the pozicija end
        }
    };
</script>

<style>
    [type="radio"]:checked,
    [type="radio"]:not(:checked) {
        display: none;
    }

    [type="radio"]:checked+label {
        position: relative;
        padding-left: 40px;
        cursor: pointer;
        line-height: 28px;
        display: inline-block;
        color: #000;
    }

    [type="radio"]:not(:checked)+label {
        position: relative;
        padding-left: 40px;
        cursor: pointer;
        line-height: 28px;
        display: inline-block;
        color: #666;
    }

    [type="radio"]:checked+label:before,
    [type="radio"]:not(:checked)+label:before {
        content: "";
        position: absolute;
        left: -1px;
        top: -1px;
        width: 30px;
        height: 30px;
        border: 1px solid #ddd;
        border-radius: 100%;
        background: #fff;
    }

    [type="radio"]:checked+label:after,
    [type="radio"]:not(:checked)+label:after {
        content: "";
        width: 20px;
        height: 20px;
        background: #0d2c5a;
        position: absolute;
        top: 4px;
        left: 4px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }

    [type="radio"]:not(:checked)+label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
    }

    [type="radio"]:checked+label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .pozicijaDivScrollMargin {
        scroll-margin-top: -20vh;
        height: 9rem;
    }

    .subCategoryDivScrollMargin {
        scroll-margin-top: -20vh;
    }

    .categoryDivScrollMargin {
        scroll-margin-top: -20vh;
    }

    @media (max-width: 880px) {
        .pozicijaDivScrollMargin {
            height: 10.5rem !important;
            scroll-margin-top: 30vh;
        }

        .subCategoryDivScrollMargin {
            scroll-margin-top: 30vh;
        }

        .categoryDivScrollMargin {
            scroll-margin-top: 30vh;
        }
    }

    @media (min-height: 850px) {
        .pozicijaDivScrollMargin {
            scroll-margin-top: 0 !important
        }

        .subCategoryDivScrollMargin {
            scroll-margin-top: 0 !important;
        }

        .categoryDivScrollMargin {
            scroll-margin-top: 0 !important;
        }
    }

    @media (max-height: 850px) {
        .pozicijaDivScrollMargin {
            scroll-margin-top: 20vh !important
        }

        .subCategoryDivScrollMargin {
            scroll-margin-top: 20vh !important;
        }

        .categoryDivScrollMargin {
            scroll-margin-top: 20vh !important;
        }
    }

    .sBtn-text-pozicija {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }

    .pozicijaQtyDivScrollMargin {
        scroll-margin-top: 20vh;
    }
</style>

