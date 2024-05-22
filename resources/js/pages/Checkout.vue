<template>
    <v-container class="pt-7">
        <v-row>
            <v-col xl="8" lg="10" class="mx-auto">
                <h1 class="fs-24 fw-700 opacity-80 mb-4">
                    {{ $t("checkout") }}
                </h1>
                <div class="mb-4">
                    <address-dialog
                        :show="addDialogShow"
                        @close="addressDialogClosed"
                        :old-address="addressSelectedForEdit"
                    />
                    <h3 class="opacity-80 mb-3 fs-20">
                        {{ $t("shipping_address") }}
                    </h3>
                    <div class="mb-4">
                        <div
                            class="position-relative mb-3"
                            v-for="address in getAddresses"
                            :key="address.id"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="checkout_shipping"
                                    v-model="selectedShippingAddressId"
                                    :value="address.id"
                                    :checked="address.default_shipping"
                                    @change="
                                        shippingAddressSelected(address.id)
                                    "
                                />
                                <span
                                    class="d-flex pa-3 aiz-megabox-elem fs-13 fw-600"
                                >
                                    <span
                                        class="aiz-rounded-check flex-shrink-0 mt-1"
                                    ></span>
                                    <span
                                        class="flex-grow-1 ps-3 opacity-80 lh-1-5"
                                    >
                                        <span class="d-block"
                                            >{{ address.address }},
                                            {{ address.postal_code }}</span
                                        >
                                        <span class="d-block"
                                            >{{ address.city }},
                                            {{ address.state }},
                                            {{ address.country }}</span
                                        >
                                        <span>{{ address.phone }}</span>
                                    </span>
                                </span>
                            </label>
                            <v-btn
                                class="absolute-right-center me-3"
                                color="primary"
                                elevation="0"
                                small
                                @click="editAddress(address)"
                            >
                                {{ $t("change") }}
                            </v-btn>
                        </div>
                        <v-btn
                            class="border-dashed border-gray-300 primary--text fs-14"
                            elevation="0"
                            block
                            x-large
                            @click.stop="addDialogShow = true"
                        >
                            <i class="las la-plus"></i>
                            <span>{{ $t("add_new_address") }}</span>
                        </v-btn>
                    </div>
                    <h3 class="opacity-80 mb-3 fs-20">
                        {{ $t("billing_address") }}
                    </h3>
                    <div class="mb-4">
                        <div
                            class="position-relative mb-3"
                            v-for="address in getAddresses"
                            :key="address.id"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="checkout_billing"
                                    v-model="selectedBillingAddressId"
                                    :value="address.id"
                                    :checked="address.default_billing"
                                />
                                <span
                                    class="d-flex pa-3 aiz-megabox-elem fs-13 fw-600"
                                >
                                    <span
                                        class="aiz-rounded-check flex-shrink-0 mt-1"
                                    ></span>
                                    <span
                                        class="flex-grow-1 ps-3 opacity-80 lh-1-5"
                                    >
                                        <span class="d-block"
                                            >{{ address.address }},
                                            {{ address.postal_code }}</span
                                        >
                                        <span class="d-block"
                                            >{{ address.city }},
                                            {{ address.state }},
                                            {{ address.country }}</span
                                        >
                                        <span>{{ address.phone }}</span>
                                    </span>
                                </span>
                            </label>
                            <v-btn
                                class="absolute-right-center me-3"
                                color="primary"
                                elevation="0"
                                small
                                @click="editAddress(address)"
                            >
                                {{ $t("change") }}
                            </v-btn>
                        </div>
                    </div>
                    <div>
                        <h3 class="opacity-80 mb-3 fs-20">
                            {{ $t("delivery_option") }}
                        </h3>
                        <v-row v-if="selectedDeliveryOption !== ''">
                            <v-col cols="12" sm="6">
                                <div class="position-relative mb-3">
                                    <label class="aiz-megabox d-block">
                                        <input
                                            type="radio"
                                            name="delivery_option"
                                            v-model="selectedDeliveryOption"
                                            value="standard"
                                        />
                                        <span
                                            class="d-flex pa-3 aiz-megabox-elem fs-13"
                                        >
                                            <span
                                                class="aiz-rounded-check flex-shrink-0 mt-1"
                                            ></span>
                                            <span
                                                class="flex-grow-1 ps-3 lh-1-5"
                                            >
                                                <span class="d-block fw-600">{{
                                                    $t("standard_delivery")
                                                }}</span>
                                                <span class="d-block">
                                                    {{ $t("delivery_cost") }}:
                                                    <span class="fw-600">{{
                                                        format_price(
                                                            standardDeliveryCost
                                                        )
                                                    }}</span>
                                                    <span
                                                        v-if="
                                                            is_addon_activated(
                                                                'multi_vendor'
                                                            )
                                                        "
                                                        >/{{ $t("shop") }}</span
                                                    >
                                                </span>
                                                <span class="d-block"
                                                    >{{
                                                        $t("delivery_timing")
                                                    }}:
                                                    <span class="fw-600"
                                                        >{{ getStandardTime }}
                                                        {{ $t("days") }}</span
                                                    ></span
                                                >
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <div class="position-relative mb-3">
                                    <label class="aiz-megabox d-block">
                                        <input
                                            type="radio"
                                            name="delivery_option"
                                            v-model="selectedDeliveryOption"
                                            value="express"
                                        />
                                        <span
                                            class="d-flex pa-3 aiz-megabox-elem fs-13"
                                        >
                                            <span
                                                class="aiz-rounded-check flex-shrink-0 mt-1"
                                            ></span>
                                            <span
                                                class="flex-grow-1 ps-3 lh-1-5"
                                            >
                                                <span class="d-block fw-600">{{
                                                    $t("express_delivery")
                                                }}</span>
                                                <span class="d-block">
                                                    {{ $t("delivery_cost") }}:
                                                    <span class="fw-600">{{
                                                        format_price(
                                                            expressDeliveryCost
                                                        )
                                                    }}</span>
                                                    <span
                                                        v-if="
                                                            is_addon_activated(
                                                                'multi_vendor'
                                                            )
                                                        "
                                                        >/{{ $t("shop") }}</span
                                                    >
                                                </span>
                                                <span class="d-block"
                                                    >{{
                                                        $t("delivery_timing")
                                                    }}:
                                                    <span class="fw-600"
                                                        >{{ getExpressTime }}
                                                        {{ $t("days") }}</span
                                                    ></span
                                                >
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </v-col>
                        </v-row>
                        <div class="border red white--text rounded pa-4" v-else>
                            {{
                                $t(
                                    "sorry_delivery_is_not_available_in_this_shipping_address"
                                )
                            }}
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="opacity-80 mb-3 fs-20">
                        {{ $t("order_summary") }}
                    </h3>
                    <div class="mb-4">
                        <v-row>
                            <v-col cols="12" sm="8">
                                <div
                                    class="border border-gray-200 rounded px-6 py-5 grey lighten-5"
                                >
                                    <v-row class="">
                                        <v-col
                                            cols="8"
                                            class="fw-500 opacity-80"
                                            >{{ $t("sub_total") }}</v-col
                                        >
                                        <v-col cols="4" class="fw-700">{{
                                            format_price(
                                                getCartPrice - getCartTax,
                                                false
                                            )
                                        }}</v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col
                                            cols="8"
                                            class="fw-500 opacity-80"
                                            >{{ $t("shipping_charge") }}</v-col
                                        >
                                        <v-col cols="4" class="fw-700">
                                            {{
                                                this.selectedDeliveryOption ===
                                                "standard"
                                                    ? format_price(
                                                          standardDeliveryCost *
                                                              getCartShops.length
                                                      )
                                                    : format_price(
                                                          expressDeliveryCost *
                                                              getCartShops.length
                                                      )
                                            }}
                                        </v-col>
                                    </v-row>
                                    <v-row class="mt-0">
                                        <v-col
                                            cols="8"
                                            class="fw-500 opacity-80"
                                            >{{ $t("tax") }}</v-col
                                        >
                                        <v-col cols="4" class="fw-700">{{
                                            format_price(getCartTax, false)
                                        }}</v-col>
                                    </v-row>
                                    <v-divider class="mt-3 mb-2"></v-divider>

                                    <coupon-form
                                        v-if="
                                            !is_addon_activated('multi_vendor')
                                        "
                                        for-checkout
                                    />

                                    <v-row class="mt-0">
                                        <v-col
                                            cols="8"
                                            class="fw-500 opacity-80"
                                            >{{ $t("discount") }}</v-col
                                        >
                                        <v-col cols="4" class="fw-700">{{
                                            format_price(getTotalCouponDiscount)
                                        }}</v-col>
                                    </v-row>
                                    <v-divider class="my-3"></v-divider>
                                    <v-row class="fs-16">
                                        <v-col
                                            cols="8"
                                            class="fw-500 opacity-80"
                                            >{{ $t("total_to_pay") }}</v-col
                                        >
                                        <v-col cols="4" class="fw-700">{{
                                            format_price(totalPrice, false)
                                        }}</v-col>
                                    </v-row>
                                </div>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <banner
                                    :loading="false"
                                    :banner="
                                        $store.getters['app/banners']
                                            .checkout_page
                                    "
                                    class="checkout-banner"
                                />
                            </v-col>
                        </v-row>
                    </div>
                </div>
                <div class="mb-4">
                    <h3 class="opacity-80 mb-3 fs-20">
                        {{ $t("payment_options") }}
                    </h3>
                    <v-row class="mb-3">
                        <v-col
                            cols="2"
                            sm="4"
                            md="2"
                            v-for="(paymentMethod, i) in paymentMethods"
                            :key="i"
                            :class="[paymentMethod.status == 1 ? '' : 'd-none']"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="checkout_payment_method"
                                    :checked="
                                        selectedPaymentMethod &&
                                        paymentMethod.code ==
                                            selectedPaymentMethod.code
                                    "
                                    @change="
                                        paymentSelected($event, paymentMethod)
                                    "
                                />
                                <span
                                    class="d-block pa-3 aiz-megabox-elem text-center"
                                >
                                    <img
                                        :src="paymentMethod.img"
                                        class="img-fluid w-100"
                                        style="height: 53px"
                                    />
                                    <span class="fw-700 fs-14">{{
                                        paymentMethod.name
                                    }}</span>
                                </span>
                            </label>
                        </v-col>
                        <v-col
                            cols="2"
                            sm="4"
                            md="2"
                            :class="[
                                bdPaymentMethods?.bkash == 1 ? '' : 'd-none',
                            ]"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="checkout_payment_method"
                                    :checked="selectedPaymentMethod == 'bkash'"
                                    @change="
                                        paymentSelected($event, {
                                            code: 'bkash',
                                            name: 'Bkash',
                                            status: 1,
                                        })
                                    "
                                />
                                <span
                                    class="d-block pa-3 aiz-megabox-elem text-center"
                                >
                                    <img
                                        :src="
                                            image_path +
                                            '/assets/img/cards/bkash.png'
                                        "
                                        class="img-fluid w-100"
                                        style="height: 53px"
                                    />
                                    <span class="fw-700 fs-14">{{
                                        $t("Bkash Payment")
                                    }}</span>
                                </span>
                            </label>
                        </v-col>
                        <v-col
                            cols="2"
                            sm="4"
                            md="2"
                            :class="[
                                bdPaymentMethods?.nagad == 1 ? '' : 'd-none',
                            ]"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="checkout_payment_method"
                                    :checked="selectedPaymentMethod == 'nagad'"
                                    @change="
                                        paymentSelected($event, {
                                            code: 'nagad',
                                            name: 'Nagad',
                                            status: 1,
                                        })
                                    "
                                />
                                <span
                                    class="d-block pa-3 aiz-megabox-elem text-center"
                                >
                                    <img
                                        :src="
                                            image_path +
                                            '/assets/img/cards/nagad.png'
                                        "
                                        class="img-fluid w-100"
                                        style="height: 53px"
                                    />
                                    <span class="fw-700 fs-14">{{
                                        $t("Nagad Payment")
                                    }}</span>
                                </span>
                            </label>
                        </v-col>
                        <v-col
                            cols="2"
                            sm="4"
                            md="2"
                            :class="[
                                bdPaymentMethods?.upay == 1 ? '' : 'd-none',
                            ]"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="checkout_payment_method"
                                    :checked="selectedPaymentMethod == 'upay'"
                                    @change="
                                        paymentSelected($event, {
                                            code: 'upay',
                                            name: 'Upay',
                                            status: 1,
                                        })
                                    "
                                />
                                <span
                                    class="d-block pa-3 aiz-megabox-elem text-center"
                                >
                                    <img
                                        :src="
                                            image_path +
                                            '/assets/img/cards/upay.png'
                                        "
                                        class="img-fluid w-100"
                                        style="height: 53px"
                                    />
                                    <span class="fw-700 fs-14">{{
                                        $t("Upay Payment")
                                    }}</span>
                                </span>
                            </label>
                        </v-col>
                        <v-col
                            cols="2"
                            sm="4"
                            md="2"
                            :class="[
                                bdPaymentMethods?.aamarpay == 1 ? '' : 'd-none',
                            ]"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="checkout_payment_method"
                                    :checked="
                                        selectedPaymentMethod == 'aamarpay'
                                    "
                                    @change="
                                        paymentSelected($event, {
                                            code: 'aamarpay',
                                            name: 'Aamarpay',
                                            status: 1,
                                        })
                                    "
                                />
                                <span
                                    class="d-block pa-3 aiz-megabox-elem text-center"
                                >
                                    <img
                                        :src="
                                            image_path +
                                            '/assets/img/cards/aamarpay.png'
                                        "
                                        class="img-fluid w-100"
                                        style="height: 53px"
                                    />
                                    <span class="fw-700 fs-14">{{
                                        $t("Aamarpay")
                                    }}</span>
                                </span>
                            </label>
                        </v-col>
                        <v-col
                            cols="6"
                            sm="4"
                            md="3"
                            v-for="(
                                offlinePaymentMethod, i
                            ) in offlinePaymentMethods"
                            :key="offlinePaymentMethod.code"
                        >
                            <label class="aiz-megabox d-block">
                                <input
                                    type="radio"
                                    name="wallet_payment_method"
                                    :checked="
                                        selectedPaymentMethod &&
                                        offlinePaymentMethod.code ==
                                            selectedPaymentMethod.code
                                    "
                                    @change="
                                        paymentSelected(
                                            $evenft,
                                            offlinePaymentMethod
                                        )
                                    "
                                />
                                <span
                                    class="d-block pa-3 aiz-megabox-elem text-center"
                                >
                                    <img
                                        :src="offlinePaymentMethod.img"
                                        class="img-fluid w-100"
                                    />
                                    <span class="fw-700 fs-13">{{
                                        offlinePaymentMethod.name
                                    }}</span>
                                </span>
                            </label>
                        </v-col>
                    </v-row>
                    <!-- show offline payment method's data -->
                    <div
                        v-if="
                            selectedPaymentMethod &&
                            selectedPaymentMethod.code.includes(
                                'offline_payment'
                            )
                        "
                        class="my-3"
                    >
                        <h3 class="opacity-80 mb-3 fs-18 text-capitalize">
                            {{ $t("account_details") }}
                        </h3>
                        <div class="border px-2 py-2">
                            <div class="text-capitalize my-1">
                                <span class="font-weight-bold">{{
                                    $t("payment_name")
                                }}</span>
                                : {{ selectedPaymentMethod.name }}
                            </div>
                            <div class="text-capitalize my-1">
                                <span class="font-weight-bold">{{
                                    $t("payment_type")
                                }}</span>
                                : {{ selectedPaymentMethod.type_show }}
                            </div>
                            <div
                                class="text-capitalize d-flex my-1"
                                v-if="selectedPaymentMethod.description"
                            >
                                <span class="font-weight-bold me-1"
                                    >{{ $t("description") }} :</span
                                >
                                <span
                                    v-html="selectedPaymentMethod.description"
                                ></span>
                            </div>
                            <div
                                class="text-capitalize"
                                v-if="
                                    selectedPaymentMethod.bank_info.length > 0
                                "
                            >
                                <span class="font-weight-bold"
                                    >{{ $t("bank_info") }}:</span
                                >
                                <div
                                    class="border px-2 py-2 mt-2"
                                    v-for="(
                                        bankInfo, i
                                    ) in selectedPaymentMethod.bank_info"
                                    :key="bankInfo.bank_name"
                                >
                                    <div>
                                        {{ $t("bank_name") }}:
                                        {{ bankInfo.bank_name }}
                                    </div>
                                    <div>
                                        {{ $t("account_name") }}:
                                        {{ bankInfo.account_name }}
                                    </div>
                                    <div>
                                        {{ $t("account_number") }}:
                                        {{ bankInfo.account_number }}
                                    </div>
                                    <div>
                                        {{ $t("routing_number") }}:
                                        {{ bankInfo.routing_number }}
                                    </div>
                                </div>
                            </div>

                            <!-- show offline payment method's inputs -->
                            <div
                                v-if="
                                    selectedPaymentMethod &&
                                    selectedPaymentMethod.code.includes(
                                        'offline_payment'
                                    )
                                "
                            >
                                <v-text-field
                                    class="my-2"
                                    :placeholder="$t('transaction_id')"
                                    type="text"
                                    v-model="transactionId"
                                    hide-details="auto"
                                    required
                                    outlined
                                >
                                </v-text-field>

                                <v-file-input
                                    accept="image/*"
                                    :placeholder="$t('add_receipt')"
                                    flat
                                    outlined
                                    prepend-icon=""
                                    clearable
                                    v-model="receipt"
                                ></v-file-input>
                            </div>
                            <!-- show offline payment method's inputs -->
                        </div>
                    </div>

                    <template v-if="generalSettings.wallet_system == 1">
                        <div class="mt-4 mb-3 fs-16 fw-700">
                            {{ $t("or") }},
                        </div>
                        <div
                            :class="[
                                'border rounded pa-4 d-flex',
                                {
                                    'bg-soft-primary border-primary':
                                        selectedPaymentMethod &&
                                        selectedPaymentMethod.code == 'wallet',
                                },
                            ]"
                        >
                            <recharge-dialog
                                :show="rechargeDialogShow"
                                from="/checkout"
                                @close="rechargeDialogClosed"
                            />
                            <v-row align="center">
                                <v-col cols="12" sm="4">
                                    <v-btn
                                        color="red"
                                        elevation="0"
                                        class="px-7 white--text"
                                        @click.stop="walletSelected()"
                                        >{{ $t("pay_with_wallet") }}</v-btn
                                    >
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="4"
                                    class="text-sm-center lh-1-5"
                                >
                                    <div>
                                        <span
                                            >{{
                                                $t("your_wallet_balance")
                                            }}
                                            :</span
                                        >
                                        <span class="fw-700 fs-15">{{
                                            format_price(currentUser.balance)
                                        }}</span>
                                    </div>
                                    <div
                                        v-if="
                                            selectedPaymentMethod &&
                                            selectedPaymentMethod.code ==
                                                'wallet'
                                        "
                                    >
                                        <span
                                            >{{
                                                $t("remaining_balance")
                                            }}
                                            :</span
                                        >
                                        <span class="fw-700 fs-15">{{
                                            format_price(
                                                currentUser.balance - totalPrice
                                            )
                                        }}</span>
                                    </div>
                                </v-col>
                                <v-col cols="12" sm="4" class="text-sm-end">
                                    <v-btn
                                        color="grey lighten-4"
                                        elevation="0"
                                        class="px-7"
                                        @click.stop="rechargeDialogShow = true"
                                        >{{ $t("recharge_wallet") }}</v-btn
                                    >
                                </v-col>
                            </v-row>
                        </div>
                    </template>
                </div>
                <div>
                    {{ $t("by_clicking_proceed_i_agree_to") }}
                    {{ $store.getters["app/appName"] }}'s
                    <router-link
                        :to="{
                            name: 'CustomPage',
                            params: { pageSlug: 'terms-and-conditions' },
                        }"
                        class="primary--text fw-500"
                    >
                        {{ $t("terms_and_conditions") }}
                    </router-link>

                    <button id="bKash_button" class="d-none">
                        Pay With bKash
                    </button>
                </div>
                <!-- <div class="my-8">

                    <v-btn color="primary" elevation="0" class="" @click.prevent="bkashRefund()" :loading="checkoutLoading" :disabled="checkoutLoading">Bkash Refund</v-btn>

                </div> -->

                <div class="my-8">
                    <v-btn
                        elevation="0"
                        color="primary"
                        class=""
                        x-large
                        @click="proceedCheckout"
                        :loading="checkoutLoading"
                        :disabled="checkoutLoading"
                    >
                        <input type="hidden" id="cartTotal" ref="cartTotal" />
                        <span class="">{{ $t("proceed") }}</span>

                        <span class="border-start border-gray-400 ps-5 ms-5">{{
                            format_price(totalPrice)
                        }}</span>
                    </v-btn>
                </div>

                <Payment ref="makePayment" />
                <FailedDialog ref="failedPayment" />
                <v-overlay :value="checkoutLoading" z-index="99999">
                    <v-progress-circular
                        indeterminate
                        size="64"
                    ></v-progress-circular>
                </v-overlay>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";
import AddressDialog from "../components/address/AddressDialog.vue";
import RechargeDialog from "../components/wallet/RechargeDialog.vue";
import Payment from "./../components/payment/Payment";
import FailedDialog from "./../components/payment/FailedDialog";
import CouponForm from "../components/cart/CouponForm";
export default {
    name: "AizShopCheckout",
    components: {},
    data() {
        return {
            scriptSrc:
                "https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js",

            image_path: window.location.origin + "/public",
            checkoutLoading: false,
            selectedShippingAddressId: null,
            selectedBillingAddressId: null,
            selectedPaymentMethod: null,
            selectedDeliveryOption: "",
            standardDeliveryCost: 0,
            expressDeliveryCost: 0,
            addDialogShow: false,
            addressSelectedForEdit: {},
            rechargeDialogShow: false,
            transactionId: null,
            receipt: null,
            createPaymentData: {},
            bdPaymentMethods: {},
            total_amount: 0,
            cartPrice: 0,
        };
    },

    components: {
        AddressDialog,
        RechargeDialog,
        Payment,
        FailedDialog,
        CouponForm,
    },
    computed: {
        ...mapGetters("app", [
            "generalSettings",
            "appUrl",
            "paymentMethods",
            "offlinePaymentMethods",
        ]),
        ...mapGetters("address", [
            "getAddresses",
            "getDefaultShippingAddress",
            "getDefaultBillingAddress",
        ]),
        ...mapGetters("cart", [
            "getCartPrice",
            "getTotalCouponDiscount",
            "getCartTax",
            "getCartShops",
            "getStandardTime",
            "getExpressTime",
            "getAllCouponCodes",
            "getSelectedCartIds",
            "checkShopMinOrder",
        ]),
        ...mapGetters("auth", ["currentUser"]),
        totalPrice() {
            return this.selectedDeliveryOption === "standard"
                ? this.getCartPrice -
                      this.getTotalCouponDiscount +
                      this.standardDeliveryCost * this.getCartShops.length
                : this.getCartPrice -
                      this.getTotalCouponDiscount +
                      this.expressDeliveryCost * this.getCartShops.length;
        },
    },

    mounted() {
        // this.$router.push({ name: "Cancel" });

        if (this.$route.query.cart_payment && this.$route.query.order_code) {
            if (this.$route.query.cart_payment == "success") {
                this.$router
                    .push({
                        name: "OrderConfirmed",
                        query: {
                            orderCode: this.$route.query.order_code,
                        },
                    })
                    .catch(() => {});
                this.snack({ message: "Payment successful!" });
            } else if (this.$route.query.cart_payment == "failed") {
                this.$refs.failedPayment.open({
                    orderCode: this.$route.query.order_code,
                    paymentMethod: this.$route.query.payment_method,
                });
            }
        }

        this.rechargeWallet(this.$route.query.wallet_payment);

        const script = document.createElement("script");
        script.src = this.scriptSrc;
        script.addEventListener("load", () => {
            this.setLoaded(this.cartPrice);
        });

        document.head.appendChild(script);

        // let product_total_price = $("#cartTotal").val();

        // let cartPrice = this.getCartPrice;

        // let script = document.createElement("script");
        // script.src =
        //     "https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js";
        // script.addEventListener("load", () => {
        //     this.setLoaded(cartPrice);
        // });
        // document.body.appendChild(script);
    },

    methods: {
        ...mapActions("cart", ["resetCoupon", "removeMultipleFromCart"]),
        ...mapActions("address", ["fetchAddresses"]),
        ...mapActions("auth", ["rechargeWallet", "deductFromWallet"]),
        addressDialogClosed() {
            this.addressSelectedForEdit = {};
            this.addDialogShow = false;
        },
        editAddress(address) {
            this.addressSelectedForEdit = address;
            this.addDialogShow = true;
        },
        rechargeDialogClosed() {
            this.rechargeDialogShow = false;
        },
        paymentSelected(event, paymentMethod) {
            this.selectedPaymentMethod = paymentMethod;
        },
        walletSelected() {
            if (this.currentUser.balance >= this.totalPrice) {
                this.selectedPaymentMethod = {
                    code: "wallet",
                };
            } else {
                this.snack({
                    message: `You don't have enough wallet balance. Please recharge.`,
                    color: "red",
                });
            }
        },
        shippingAddressSelected(address_id) {
            this.getShippingCost(address_id);
        },

        // BD Payment Methods
        async getBDPaymentMethod() {
            const bd_payment = await this.call_api(
                "get",
                "get-bd-payment-methods"
            );
            console.log("bd_payment", bd_payment.data);
            this.bdPaymentMethods = bd_payment.data;
        },
        async getShippingCost(address_id) {
            const res = await this.call_api(
                "get",
                `checkout/get-shipping-cost/${address_id}`
            );
            this.selectedDeliveryOption = res.data.success ? "standard" : "";
            this.standardDeliveryCost = parseFloat(
                res.data.standard_delivery_cost
            );
            this.expressDeliveryCost = parseFloat(
                res.data.express_delivery_cost
            );
        },

        async orderProcessing() {
            this.checkoutLoading = true;
            if (this.getSelectedCartIds.length == 0) {
                this.checkoutLoading = false;
                this.snack({
                    message: `Please select a cart product`,
                    color: "red",
                });
                return;
            }
            if (this.getAddresses.length == 0) {
                this.checkoutLoading = false;
                this.snack({
                    message: `Please add a delivery address`,
                    color: "red",
                });
                return;
            }

            if (!this.selectedShippingAddressId) {
                this.checkoutLoading = false;
                this.snack({
                    message: `Please select a delivery address`,
                    color: "red",
                });
                return;
            }
            if (!this.selectedBillingAddressId) {
                this.checkoutLoading = false;
                this.snack({
                    message: `Please select a billing address`,
                    color: "red",
                });
                return;
            }
            if (this.selectedDeliveryOption === "") {
                this.checkoutLoading = false;
                this.snack({
                    message: `Sorry, delivery is not available in this shipping address.`,
                    color: "red",
                });
                return;
            }

            if (!this.selectedPaymentMethod) {
                this.checkoutLoading = false;
                this.snack({
                    message: `Please select a payment method`,
                    color: "red",
                });

                return;
            }

            if (
                this.selectedPaymentMethod &&
                this.selectedPaymentMethod.code.includes("offline_payment") &&
                this.transactionId === null
            ) {
                this.checkoutLoading = false;
                this.snack({
                    message: this.$i18n.t("please_input_transaction_id"),
                    color: "red",
                });
                return;
            }

            if (!this.checkShopMinOrder.success) {
                this.snack({
                    message: this.checkShopMinOrder.message,
                    color: "red",
                });
                return;
            }

            let formData = new FormData();
            formData.append(
                "shipping_address_id",
                this.selectedShippingAddressId
            );
            formData.append(
                "billing_address_id",
                this.selectedBillingAddressId
            );
            formData.append("payment_type", this.selectedPaymentMethod.code);
            formData.append("delivery_type", this.selectedDeliveryOption);

            let cartIds = this.getSelectedCartIds;
            cartIds.forEach((item, index) => {
                formData.append("cart_item_ids[]", item);
            });

            let coupon_codes = this.getAllCouponCodes;
            coupon_codes.forEach((couponItem, couponItemIndex) => {
                formData.append("coupon_codes[]", couponItem);
            });

            formData.append("transactionId", this.transactionId);
            formData.append("receipt", this.receipt);

            if (this.getCartPrice > 0) {
                // this.checkoutLoading = true;
                const res = await this.call_api(
                    "post",
                    "checkout/order/store",
                    formData
                );

                this.setLoaded(res.data.grand_total);

                this.$refs.cartTotal.value = res.data.grand_total;

                window.localStorage.removeItem("tmt");
                window.localStorage.setItem("tmt", res.data.grand_total);

                if (res.data.success) {
                    if (res.data.payment_method == "wallet") {
                        this.deductFromWallet(res.data.grand_total);
                    }

                    if (res.data.go_to_payment) {
                        console.log("I am here now!");
                        this.$refs.makePayment.pay({
                            requestedFrom: "/checkout",
                            paymentAmount: 0,
                            paymentMethod: res.data.payment_method,
                            paymentType: "cart_payment",
                            userId: this.currentUser.id,
                            oderCode: res.data.order_code,
                        });
                    } else {
                        if (res.data.payment_method == "bkash") {
                            const bkash_response = await this.call_api(
                                "post",
                                "bkash/pay",
                                {
                                    order_code: res.data.order_code,
                                    amount: res.data.grand_total,
                                }
                            );

                            const update_combined_order = await this.call_api(
                                "post",
                                "bkash/update-combined-order",
                                {
                                    order_code: res.data.order_code,
                                    paymentID: bkash_response.data.paymentID,
                                }
                            );

                            if (bkash_response.data.paymentID != null) {
                                console.log(
                                    "bkash_response.data",
                                    bkash_response
                                );

                                bkash_response.data.amount =
                                    res.data.grand_total;
                                this.total_amount = res.data.grand_total;
                                this.createPaymentData = bkash_response.data;

                                console.log(
                                    "createPaymentData",
                                    this.createPaymentData
                                );

                                $("#bKash_button").trigger(
                                    "click",
                                    function () {
                                        this.cartPrice = res.data.grand_total;
                                    }
                                );
                            }
                        } else if (res.data.payment_method == "nagad") {
                            const nagad_response = await this.call_api(
                                "post",
                                "nagad/pay",
                                {
                                    order_code: res.data.order_code,
                                    amount: res.data.grand_total,
                                }
                            );
                            console.log("nagad response", nagad_response);
                            // return false;
                            window.location.href = nagad_response.data.url;
                        } else if (res.data.payment_method == "upay") {
                            window.location.href =
                                window.location.origin +
                                "/upay/create-payment?order_code=" +
                                res.data.order_code +
                                "&amount=" +
                                res.data.grand_total;
                        } else if (res.data.payment_method == "aamarpay") {
                            const aamarpay_response = await this.call_api(
                                "post",
                                "aamarpay/pay",
                                {
                                    order_code: res.data.order_code,
                                    amount: res.data.grand_total,
                                    cus_name: res.data.user.name,
                                    cus_email: res.data.user.email,
                                    cus_email: res.data.user.email,
                                    cus_add1: res.data.addresses.address,
                                    cus_city: res.data.addresses.city,
                                    cus_state: res.data.addresses.state,
                                    cus_postcode:
                                        res.data.addresses.postal_code,
                                    cus_phone: res.data.addresses.phone,
                                }
                            );

                            window.location.href = aamarpay_response.data;
                        } else {
                            // order-confirmed
                            this.$router
                                .push({
                                    name: "OrderConfirmed",
                                    query: { orderCode: res.data.order_code },
                                })
                                .catch(() => {});
                        }
                    }
                    setTimeout(() => {
                        this.resetCoupon();
                        this.removeMultipleFromCart(this.getSelectedCartIds);
                    }, 2000);
                } else {
                    this.snack({
                        message: res.data.message,
                        color: "red",
                    });
                }
                this.checkoutLoading = false;
            }
        },

        async proceedCheckout() {
            this.orderProcessing();
        },

        async setLoaded(cartPrice) {
            var paymentID = "";
            var _route = this.$router;
            var _this = this;

            console.log("cart price", cartPrice);
            bKash.init({
                paymentMode: "checkout", //fixed value ‘checkout’
                //paymentRequest
                // format: { amount: cartPrice, intent: "sale" },
                //intent options
                //1) ‘sale’ – immediate transaction (2 API calls)
                //2) ‘authorization’ – deferred transaction (3 API calls)
                paymentRequest: {
                    amount: cartPrice, //max two decimal points allowed
                    intent: "sale",
                },
                async createRequest(request) {
                    if (
                        _this.createPaymentData &&
                        _this.createPaymentData.paymentID != null
                    ) {
                        paymentID = _this.createPaymentData.paymentID;

                        bKash.create().onSuccess(_this.createPaymentData);

                        const callback = await _this.call_api(
                            "post",
                            "bkash/checkout-url/callback",
                            { paymentID: paymentID, status: "success" }
                        );
                    } else {
                        const callback = await _this.call_api(
                            "post",
                            "bkash/checkout-url/callback",
                            { paymentID: paymentID, status: "cancel" }
                        );
                        // return false;

                        const queryParams = {
                            payment_type: "bkash",
                            errorMsg: _this.createPaymentData.data.errorMessage,
                        };

                        _route.push({
                            name: "Cancel",
                            query: queryParams,
                        });

                        // window.location.href =
                        //     window.location.origin +
                        //     "/cancel?payment_type=bkash&errorMsg=" +
                        //     _this.createPaymentData.data.errorMessage;
                        bKash.create().onError();
                    }
                },
                async executeRequestOnAuthorization() {
                    let executeRes = await _this.call_api(
                        "post",
                        "bkash/execute-payment",
                        {
                            paymentID: paymentID,
                        }
                    );

                    if (executeRes.data.paymentID != null) {
                        console.log("executeRes", executeRes.data);
                        _route.push({
                            name: "OrderConfirmed",
                            query: {
                                orderCode:
                                    executeRes.data.merchantInvoiceNumber,
                            },
                        });

                        const callback = await _this.call_api(
                            "post",
                            "bkash/checkout-url/callback",
                            { paymentID: paymentID, status: "success" }
                        );
                    } else {
                        // _route.push({
                        //     path:'/cancel',
                        //     query:{payment_type:'bkash', errorMsg:executeRes.errorMessage}
                        // })

                        const callback = await _this.call_api(
                            "post",
                            "bkash/checkout-url/callback",
                            { paymentID: paymentID, status: "cancel" }
                        );

                        // return false;
                        const queryParams = {
                            payment_type: "bkash",
                            errorMsg: executeRes.data.errorMessage,
                        };

                        _route.push({
                            name: "Cancel",
                            query: queryParams,
                        });

                        // window.location.href =
                        //     window.location.origin +
                        //     "/cancel?payment_type=bkash&errorMsg=" +
                        //     executeRes.data.errorMessage;
                        bKash.execute().onError();
                    }
                },

                async onClose() {
                    // _route.push({
                    //         path:'/cancel',
                    //         query:{payment_type:'bkash', errorMsg:"Bkash Payment has been <strong>cancelled!</strong> Try again"}

                    //     })

                    const callback = await _this.call_api(
                        "post",
                        "bkash/checkout-url/callback",
                        { paymentID: paymentID, status: "cancel" }
                    );

                    const queryParams = {
                        payment_type: "bkash",
                        errorMsg:
                            "Bkash Payment has been <strong>cancelled!</strong> Try again",
                    };

                    _route.push({
                        name: "Cancel",
                        query: queryParams,
                    });

                    // window.location.href =
                    //     window.location.origin +
                    //     "/cancel?payment_type=bkash&errorMsg=Bkash Payment has been <strong>cancelled!</strong> Try again";
                },
            });
        },

        async bkashRefund() {
            const query = await this.call_api("post", "bkash/query-payment", {
                paymentID: "TR00119F1666420768226",
            });

            console.log("query", query.data);
            const res = await this.call_api("post", "bkash/refund", {
                paymentID: query.data.paymentID,
                amount: query.data.amount,
                trxID: query.data.trxID,
                sku: "ORD2022102029162677",
                reason: "product not received",
            });

            console.log("data", res.data);
        },
    },

    async created() {
        await this.fetchAddresses();
        this.selectedShippingAddressId = this.getDefaultShippingAddress.id;
        this.selectedBillingAddressId = this.getDefaultBillingAddress.id;
        this.getShippingCost(this.selectedShippingAddressId);
        this.getBDPaymentMethod();
    },
};
</script>
<style>
@media (min-width: 600px) {
    .checkout-banner img {
        height: 281px;
        object-fit: cover;
    }
}
</style>
