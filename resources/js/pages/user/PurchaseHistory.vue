<template>
    <div class="ps-lg-7 pt-4">
        <h1 class="fs-24 fw-700 opacity-80 mb-5 mt-3">
            {{ $t("purchase_history") }}
        </h1>
        <div>
            <v-data-table
                :headers="headers"
                :items="orders"
                class="border px-4 pt-3"
                :loading-text="$t('loading_please_wait')"
                hide-default-footer
                :loading="loading"
                item-class="c-pointer"
                @click:row="openOrderDetails"
            >
                <template v-slot:[`item.details`]="{ item }">
                    <span class="d-block fw-600">{{ item.code }}</span>
                    <span class="opacity-50 fs-13 fw-600">{{ item.date }}</span>
                </template>

                <template v-slot:[`item.info`]="{ item }">
                    <span class="d-block fw-600">{{ getProductsCount(item) }} {{ $t('products') }}</span>
                    <span v-if="is_addon_activated('multi_vendor')" class="fs-13 opacity-60">{{ $t('from') }} {{ item.orders.length }} {{ $t('shops') }}</span>
                </template>

                <template v-slot:[`item.grand_total`]="{ item }">
                    <span class="d-block fw-600">{{ format_price(item.grand_total) }}</span>
                </template>

                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn @click="openOrderDetails(item)" text small class="px-2 text-primary">
                        {{ $t('view_details') }}
                    </v-btn>
                </template>

            </v-data-table>

            <div class="text-start" v-if="totalPages > 1">
                <v-pagination
                    v-model="currentPage"
                    @input="getList"
                    :length="totalPages"
                    prev-icon="la-angle-left"
                    next-icon="la-angle-right"
                    :total-visible="7"
                    elevation="0"
                    class="my-4"
                ></v-pagination>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        loading: true,
        currentPage: 1,
        totalPages: 1,
        orders: [],
        selectedOrder: {},
    }),
    computed: {
        headers() {
            return [
                {
                    text: this.$i18n.t("details"),
                    align: "start",
                    sortable: false,
                    value: "details",
                },
                {
                    text: this.$i18n.t("info"),
                    sortable: false,
                    value: "info",
                },
                {
                    text: this.$i18n.t("amount"),
                    sortable: false,
                    value: "grand_total",
                },
                {
                    text: this.$i18n.t("actions"),
                    sortable: false,
                    align: "end",
                    value: "actions",
                },
            ];
        },
    },
    watch: {
        currentPage() {
            this.$router
                .push({
                    query: {
                        ...this.$route.query,
                        page: this.currentPage,
                    },
                })
                .catch(() => {});
        },
    },
    methods: {
        getProductsCount(combinedOrder){
            let count = 0
            combinedOrder.orders.forEach(order => {
                count += order.products.data.length
            })
            return count
        },
        async getList(number) {
            this.loading = true;
            const res = await this.call_api(
                "get",
                `user/orders?page=${number}`
            );
            if (res.data.success) {
                this.orders = res.data.data;
                this.totalPages = res.data.meta.last_page;
                this.currentPage = res.data.meta.current_page;
            } else {
                this.snack({
                    message: this.$i18n.t("something_went_wrong"),
                    color: "red",
                });
            }
            this.loading = false;
        },
        openOrderDetails(order) {
            this.$router.push({ name: "OrderDetails", params: { code: order.code } });
        },
    },
    created() {
        let page = this.$route.query.page || this.currentPage;
        this.getList(page);
    },
};
</script>
