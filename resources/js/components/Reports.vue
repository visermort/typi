<template>
    <div class="reports">
        <div class="preloader" v-if="loading" v-html="preloader"></div>
        <div class="mb-4 card" v-for="section in sections">
            <h4 class="card-header">{{ section.title}}</h4>
            <div class="section-desctrption card-header">
                {{ section.description }}
            </div>
            <div class="section-itemlist">
                <div class="section-item" v-for="item in section.items">
                    <div class="section-item-elem section-item-elem-title">{{ item.title}}</div>
                    <div class="section-item-elem section-item-elem-secription">{{ item.description }}</div>
                    <div class="section-item-elem section-item-elem-value">{{ item.value }}</div>
                    <div class="section-item-elem section-item-elem-measure">{{ item.measure }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
        },
        data() {
            return {
                sections: [],
                loading: false,
                url: '/admin/reports/data',
                preloader: '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' +
                    '<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="158px" height="24px" viewBox="0 0 158 24" xml:space="preserve">' +
                    '<path fill="#e3e3e3" fill-opacity="0.11" d="M64 4h10v10H64V4zm20 0h10v10H84V4zm20 0h10v10h-10V4zm20 0h10v10h-10V4zm20 0h10v10h-10V4zM4 4h10v10H4V4zm20 0h10v10H24V4zm20 0h10v10H44V4z"/><path fill="#bdbdbd" fill-opacity="0.26" d="M144 14V4h10v10h-10zm9-9h-8v8h8V5zm-29 9V4h10v10h-10zm9-9h-8v8h8V5zm-29 9V4h10v10h-10zm9-9h-8v8h8V5zm-29 9V4h10v10H84zm9-9h-8v8h8V5zm-29 9V4h10v10H64zm9-9h-8v8h8V5zm-29 9V4h10v10H44zm9-9h-8v8h8V5zm-29 9V4h10v10H24zm9-9h-8v8h8V5zM4 14V4h10v10H4zm9-9H5v8h8V5z"/><g><path fill="#d9d9d9" fill-opacity="0.15" d="M-58 16V2h14v14h-14zm13-13h-12v12h12V3z"/><path fill="#9c9c9c" fill-opacity="0.39"  d="M-40 0h18v18h-18z"/><path fill="#b2b2b2" fill-opacity="0.3" d="M-40 18V0h18v18h-18zm17-17h-16v16h16V1z"/><path fill="#9c9c9c" fill-opacity="0.39"  d="M-20 0h18v18h-18z"/><path fill="#4c4c4c" fill-opacity="0.7" d="M-20 18V0h18v18h-18zM-3 1h-16v16h16V1z"/><animateTransform attributeName="transform" type="translate" values="20 0;40 0;60 0;80 0;100 0;120 0;140 0;160 0;180 0;200 0" calcMode="discrete" dur="1600ms" repeatCount="indefinite"/></g>' +
                    '</svg>',
            };
        },
        created() {
            this.fetchData();
        },
        mounted() {

        },
        computed: {

        },
        methods: {
            fetchData() {
                this.loading = true;
                axios
                    .get(this.url)
                    .then(response => {
                        this.sections = response.data.sections;
                        this.loading = false;
                    })
                    .catch(error => {
                        console.log(error);
                        this.loading = false;
                        alertify.error(
                            error.response.data.message || this.$i18n.t('An error occurred with the data fetch.')
                        );
                    });
            },
        },
    };
</script>
<style>
    .preloader {
        margin: 20px auto 0;
        text-align: center;
    }
    .section-desctrption {
        font-style: italic;
    }
    .section-item {
        width: 100%;
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        flex-wrap: nowrap;
    }
    .section-itemlist:not(:last-child) {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    .section-item-elem {
        padding: 10px;
    }
    .section-item-elem-title,
    .section-item-elem-value {
        font-weight: bold;
    }
    @media screen and (max-width: 480px) {
        .section-item {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
