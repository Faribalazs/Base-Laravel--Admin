<template>
    <div>

        <div class="h-36 mt-10">
            <span class="input-label pl-2">{{ title }}*</span>
            <div class="select-menu" :class="{ active: isActive }">
                <div class="select-btn" @click="toggleMenu">
                    <span class="sBtn-text">{{ selectedName }}</span>
                    <svg role="img" viewBox="0 0 512 512">
                        <path
                        d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                    </svg>
                </div>
            
                <ul class="options">
                    <li class="option">
                        <input type="text" v-model="searchQuery" :placeholder="searchPlaceholder + '...'" class="quantity-input">
                    </li>
                    <li v-for="option in data" :key="option.id" class="option" v-show="search(option)" @click="selectOption(option)">
                        <span class="option-text">{{ option.name[lang] }}</span>
                    </li>
                </ul>
            </div>

            <input type="hidden" :name="inputName" :value="selectedId" />
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'data',
            'title',
            'searchtext',
            'locale',
            'inputname',
            'preselectedname',
            'preselectedid',
        ],

        data() {
            return { 
                lang: this.locale,
                searchQuery: '',
                searchPlaceholder: this.searchtext,
                title: this.title,
                isActive: false,
                selectedName: this.title,
                selectedId: '',
                data: this.data,
                inputName: this.inputname,
            }
        },

        created() {
            if (typeof this.preselectedname !== 'undefined' && typeof this.preselectedid !== 'undefined') {
                this.selectedName = this.preselectedname;
                this.selectedId = this.preselectedid
            } else {
                this.selectedName = this.title;
            }
        },

        methods: {

            toggleMenu() {
                //show hide the dropsown content
                this.isActive = !this.isActive;
            },

            search(option) {
                const searchQuery = this.searchQuery.toLowerCase().trim();
                const optionName = option.name[this.lang].toLowerCase();
                return optionName.includes(searchQuery);
            },

            selectOption(option) {
                //set value for the hidden input
                this.selectedName = option.name[this.lang];

                if (typeof option.id_unit !== 'undefined') {
                    this.selectedId = option.id_unit; 
                } else {
                    this.selectedId = option.id;
                }

                this.isActive = false;
            },
        }
    };
</script>