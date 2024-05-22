

<?php $__env->startSection('content'); ?>
    <h1 class="h4 fw-700 mb-3"><?php echo e(translate('Order code')); ?>: <?php echo e($order->combined_order->code); ?></h1>
    <div class="row gutters-5">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h2 class="h2 fs-16 fw-600 mb-0"><?php echo e(translate('Order Details')); ?></h2>
                </div>
                <div class="card-header">
                    <div class="flex-grow-1 row">
                        <div class="col-md mb-3">
                            <div>
                                <div class="fs-15 fw-600 mb-2"><?php echo e(translate('Customer info')); ?></div>
                                <div><span class="opacity-80 mr-2 ml-0"><?php echo e(translate('Name')); ?>:</span>
                                    <?php echo e($order->user->name ?? ''); ?></div>
                                <div><span class="opacity-80 mr-2 ml-0"><?php echo e(translate('Email')); ?>:</span>
                                    <?php echo e($order->user->email ?? ''); ?></div>
                                <div><span class="opacity-80 mr-2 ml-0"><?php echo e(translate('Phone')); ?>:</span>
                                    <?php echo e($order->user->phone ?? ''); ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td class=""><?php echo e(translate('Order code')); ?>:</td>
                                        <td class="text-right text-info fw-700"><?php echo e($order->combined_order->code); ?></td>
                                    </tr>
                                    <tr>
                                        <td class=""><?php echo e(translate('Order Date')); ?>:</td>
                                        <td class="text-right fw-700"><?php echo e($order->created_at->format('d.m.Y')); ?></td>
                                    </tr>
                                    <tr>
                                        <td class=""><?php echo e(translate('Delivery type')); ?>:</td>
                                        <td class="text-right fw-700">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $order->delivery_type))); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=""><?php echo e(translate('Payment method')); ?>:</td>
                                        <td class="text-right fw-700">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_type))); ?></td>
                                    </tr>
                                    <?php if($order->payment_type == "offline_payment"): ?>
                                        <?php
                                           $manual_payment_data = json_decode($order->manual_payment_data);
                                        ?>
                                        <tr>
                                            <td class=""><?php echo e(translate('Transaction ID')); ?>:</td>
                                            <td class="text-right fw-700">
                                                <?php echo e($manual_payment_data->transactionId); ?></td>
                                        </tr>

                                        <tr>
                                            <td class=""><?php echo e(translate('Paid Via')); ?>:</td>
                                            <td class="text-right fw-700">
                                                <?php echo e($manual_payment_data->payment_method); ?></td>
                                        </tr>

                                        <?php if($manual_payment_data->reciept): ?>
                                            <tr>
                                                <td class=""><?php echo e(translate('Receipt')); ?>:</td>
                                                <td class="text-right fw-700">
                                                    <a href="<?php echo e(my_asset($manual_payment_data->reciept)); ?>" target="_blank" rel="noopener noreferrer"><?php echo e(translate('Download')); ?>

                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif; ?> 
                                    <?php endif; ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <div class="flex-grow-1 row align-items-start">

                        <div class="col-md-3 mr-auto ml-0">
                            <div class="mb-3">
                                <label class="mb-0"><?php echo e(translate('Payment Status')); ?></label>
                                <select
                                    class="form-control aiz-selectpicker"
                                    id="update_payment_status"
                                    data-minimum-results-for-search="Infinity"
                                    data-selected="<?php echo e($order->payment_status); ?>"
                                    <?php if($order->payment_status == 'paid' || $order->delivery_status == 'delivered' || $order->delivery_status == 'cancelled'): ?> disabled <?php endif; ?>
                                >
                                    <option value="paid"><?php echo e(translate('Paid')); ?></option>
                                    <option value="unpaid"><?php echo e(translate('Unpaid')); ?></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="mb-0"><?php echo e(translate('Delivery Status')); ?></label>
                                <select
                                    class="form-control aiz-selectpicker"
                                    id="update_delivery_status"
                                    data-minimum-results-for-search="Infinity"
                                    data-selected="<?php echo e($order->delivery_status); ?>"
                                    <?php if($order->delivery_status == 'delivered' || $order->delivery_status == 'cancelled'): ?> disabled <?php endif; ?>
                                >
                                    <option value="confirmed"><?php echo e(translate('Confirmed')); ?></option>
                                    <option value="processed"><?php echo e(translate('Processed')); ?></option>
                                    <option value="shipped"><?php echo e(translate('Shipped')); ?></option>
                                    <option value="delivered"><?php echo e(translate('Delivered')); ?></option>
                                    <option value="cancelled"><?php echo e(translate('Cancel')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-auto w-md-250px">
                            <?php
                                $shipping_address = json_decode($order->shipping_address);
                            ?>
                            <h5 class="fs-14 mb-3"><?php echo e(translate('Shipping address')); ?></h5>
                            <address class="">
                                <?php echo e($shipping_address->phone); ?><br>
                                <?php echo e($shipping_address->address); ?><br>
                                <?php echo e($shipping_address->city); ?>, <?php echo e($shipping_address->postal_code); ?><br>
                                <?php echo e($shipping_address->state); ?>, <?php echo e($shipping_address->country); ?>

                            </address>
                        </div>
                        <div class="col-md-auto w-md-250px">
                            <?php
                                $billing_address = json_decode($order->billing_address);
                            ?>
                            <h5 class="fs-14 mb-3"><?php echo e(translate('Billing address')); ?></h5>
                            <address class="">
                                <?php echo e($billing_address->phone); ?><br>
                                <?php echo e($billing_address->address); ?><br>
                                <?php echo e($billing_address->city); ?>, <?php echo e($billing_address->postal_code); ?><br>
                                <?php echo e($billing_address->state); ?>, <?php echo e($billing_address->country); ?>

                            </address>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="aiz-table table-bordered">
                        <thead>
                            <tr class="">
                                <th class="text-center" width="5%" data-breakpoints="lg">#</th>
                                <th width="40%"><?php echo e(translate('Product')); ?></th>
                                <th class="text-center" data-breakpoints="lg"><?php echo e(translate('Qty')); ?></th>
                                <th class="text-center" data-breakpoints="lg"><?php echo e(translate('Unit Price')); ?></th>
                                <th class="text-center" data-breakpoints="lg"><?php echo e(translate('Unit Tax')); ?></th>
                                <th class="text-center" data-breakpoints="lg"><?php echo e(translate('Total')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td>
                                        <?php if($orderDetail->product != null): ?>
                                            <div class="media">
                                                <img src="<?php echo e(uploaded_asset($orderDetail->product->thumbnail_img)); ?>"
                                                    class="size-60px mr-3">
                                                <div class="media-body">
                                                    <h4 class="fs-14 fw-400"><?php echo e($orderDetail->product->name); ?></h4>
                                                    <?php if($orderDetail->variation): ?>
                                                        <div>
                                                            <?php $__currentLoopData = $orderDetail->variation->combinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $combination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <span class="mr-2">
                                                                    <span
                                                                        class="opacity-50"><?php echo e(optional($combination->attribute)->name); ?></span>:
                                                                    <?php echo e(optional($combination->attribute_value)->name); ?>

                                                                </span>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <strong><?php echo e(translate('Product Unavailable')); ?></strong>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?php echo e($orderDetail->quantity); ?></td>
                                    <td class="text-center"><?php echo e(format_price($orderDetail->price)); ?></td>
                                    <td class="text-center"><?php echo e(format_price($orderDetail->tax)); ?></td>
                                    <td class="text-center"><?php echo e(format_price($orderDetail->total)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xl-4 col-md-6 ml-auto mr-0">
                            <table class="table">
                                <tbody>
                                    <?php
                                        $totalTax = 0;
                                        foreach ($order->orderDetails as $item) {
                                            $totalTax += $item->tax * $item->quantity;
                                        }
                                    ?>
                                    <tr>
                                        <td><strong class=""><?php echo e(translate('Sub Total')); ?> :</strong></td>
                                        <td>
                                            <?php echo e(format_price($order->orderDetails->sum('total') - $totalTax)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong class=""><?php echo e(translate('Tax')); ?> :</strong></td>
                                        <td><?php echo e(format_price($totalTax)); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong class=""> <?php echo e(translate('Shipping')); ?> :</strong></td>
                                        <td><?php echo e(format_price($order->shipping_cost)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class=""> <?php echo e(translate('Coupon discount')); ?> :</strong>
                                            <?php if($order->coupon_code): ?>
                                                <div>(<?php echo e($order->coupon_code); ?>)</div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(format_price($order->coupon_discount)); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong class=""><?php echo e(translate('TOTAL')); ?> :</strong></td>
                                        <td class=" h4">
                                            <?php echo e(format_price($order->grand_total)); ?>

                                        </td>
                                    </tr>
                                    <?php if(addon_is_activated('refund') && $order->refund_amount > 0): ?>
                                        <tr>
                                            <td>
                                                <strong class="text-danger"> <?php echo e(translate('Refunded')); ?> :</strong>
                                            </td>
                                            <td><span class="text-danger">- <?php echo e(format_price($order->refund_amount)); ?></span></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(addon_is_activated('refund')): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_refund_requests')): ?>
                    <?php $refund_request = \App\Models\RefundRequest::where('order_id',$order->id)->first(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="fs-16 mb-0"><?php echo e(translate('Refund requests')); ?></h3>
                            <?php
                                $refund_request_time_period = get_setting('refund_request_time_period');
                                $last_refund_date = $orderDetail->created_at->addDays($refund_request_time_period);
                                $today_date = Carbon\Carbon::now();
                                $refund_request_order_status = get_setting('refund_request_order_status') != null ? json_decode(get_setting('refund_request_order_status')) : [];
                                
                            ?>
                            <?php if($order->payment_status == 'paid' && in_array($order->delivery_status, $refund_request_order_status) && $refund_request == null && $today_date <= $last_refund_date): ?>
                                <a href="<?php echo e(route('admin.refund_request.create', $order->id)); ?>"
                                    class="btn btn-sm btn-primary"><?php echo e(translate('Create Refund')); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">

                            <?php if($refund_request != null): ?>
                                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="10%">#</th>
                                            <th><?php echo e(translate('Name')); ?></th>
                                            <th class="text-center" data-breakpoints="lg"><?php echo e(translate('Qty')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $refund_request->refundRequestItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $refundRequestItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td>
                                                    <div class="media">
                                                        <img src="<?php echo e(uploaded_asset($refundRequestItem->orderDetail->product->thumbnail_img)); ?>"
                                                            class="size-60px mr-3">
                                                        <div class="media-body">
                                                            <h4 class="fs-14 fw-400">
                                                                <?php echo e($refundRequestItem->orderDetail->product->name); ?>

                                                            </h4>
                                                            <?php if($refundRequestItem->orderDetail->variation): ?>
                                                                <div>
                                                                    <?php $__currentLoopData = $refundRequestItem->orderDetail->variation->combinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $combination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <span class="mr-2">
                                                                            <span
                                                                                class="opacity-50"><?php echo e($combination->attribute->name); ?></span>:
                                                                            <?php echo e($combination->attribute_value->name); ?>

                                                                        </span>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center"><?php echo e($refundRequestItem->quantity); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 ml-auto mr-0">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><strong
                                                            class=""><?php echo e(translate('Refund Amount')); ?>:</strong>
                                                    </td>
                                                    <td>
                                                        <?php echo e(format_price($refund_request->amount)); ?>

                                                    </td>
                                                </tr>
                                                <?php if($order->refund_status != null): ?>
                                                    <tr>
                                                        <td><strong class=""><?php echo e(translate('Refund Type')); ?>

                                                                :</strong></td>
                                                        <td><?php echo e($order->refund_status == 'partially_refunded' ? translate('Partial') : translate('Full')); ?>

                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if($refund_request->shop->user->user_type == 'seller'): ?>
                                                    <tr>
                                                        <td>
                                                            <strong
                                                                class=""><?php echo e(translate('Seller Approval')); ?>:</strong>
                                                        </td>
                                                        <td>
                                                            <?php if($refund_request->seller_approval == 0): ?>
                                                                <span
                                                                    class="badge badge-inline badge-info"><?php echo e(translate('Pending')); ?></span>
                                                            <?php elseif($refund_request->seller_approval == 1): ?>
                                                                <span
                                                                    class="badge badge-inline badge-success"><?php echo e(translate('Accepted')); ?></span>
                                                            <?php elseif($refund_request->seller_approval == 2): ?>
                                                                <span
                                                                    class="badge badge-inline badge-danger"><?php echo e(translate('Rejected')); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td><strong class=""><?php echo e(translate('Status')); ?>

                                                            :</strong></td>
                                                    <td>
                                                        <?php if($refund_request->admin_approval == 0): ?>
                                                            <span
                                                                class="badge badge-inline badge-info"><?php echo e(translate('Pending')); ?></span>
                                                        <?php elseif($refund_request->admin_approval == 1): ?>
                                                            <span
                                                                class="badge badge-inline badge-success"><?php echo e(translate('Accepted')); ?></span>
                                                        <?php elseif($refund_request->admin_approval == 2): ?>
                                                            <span
                                                                class="badge badge-inline badge-danger"><?php echo e(translate('Rejected')); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong class=""><?php echo e(translate('Options')); ?>:</strong>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                                            onclick="show_refund_request_info('<?php echo e($refund_request->id); ?>');"
                                                            title="<?php echo e(translate('Refund Request Info')); ?>"
                                                            href="javascript:void(0)">
                                                            <i class="las la-eye"></i>
                                                        </a>
                                                        <?php if($refund_request->admin_approval == 0): ?>
                                                            <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                                                onclick="accept_refund_request(<?php echo e($refund_request->id); ?>,<?php echo e($refund_request->amount); ?>)"
                                                                title="<?php echo e(translate('Accept Refund Request')); ?>"
                                                                href="javascript:void(0)">
                                                                <i class="las la-check"></i>
                                                            </a>
                                                            <a class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                                                onclick="reject_refund_request('<?php echo e(route('admin.refund_request.reject', $refund_request->id)); ?>')"
                                                                title="<?php echo e(translate('Reject Refund Request')); ?>"
                                                                href="javascript:void(0)">
                                                                <i class="las la-times"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(addon_is_activated('multi_vendor') && optional(optional($order->shop)->user)->user_type != 'admin'): ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="fs-16 mb-0"><?php echo e(translate('Earning History')); ?></h3>
                    </div>
                    <div class="card-body">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(translate('Admin Commission')); ?></th>
                                    <th><?php echo e(translate('Seller Earning')); ?></th>
                                    <th data-breakpoints="lg"><?php echo e(translate('Details')); ?></th>
                                    <th class="text-center"><?php echo e(translate('Type')); ?></th>
                                    <th data-breakpoints="lg" class="text-right"><?php echo e(translate('Calculated At')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->commission_histories()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(($key+1)); ?></td>
                                    <td><?php echo e(format_price($history->admin_commission)); ?></td>
                                    <td><?php echo e(format_price($history->seller_earning)); ?></td>
                                    <td><?php echo e($history->details); ?></td>
                                    <td class="text-center">
                                        <?php if($history->type == 'Added'): ?>
                                            <span class="badge badge-inline badge-success"><?php echo e(translate($history->type)); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-inline badge-danger"><?php echo e(translate($history->type)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right"><?php echo e($history->created_at); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col col-lg-auto w-lg-300px">
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-16 mb-0"><?php echo e(translate('Tracking information')); ?></h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('orders.add_tracking_information')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                        <div class="form-group mb-1">
                            <label class="mb-0"><?php echo e(translate('Courier name')); ?>:</label>
                            <input type="text" class="form-control form-control-sm" name="courier_name" value="<?php echo e($order->courier_name); ?>" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="mb-0"><?php echo e(translate('Tracking number')); ?>:</label>
                            <input type="text" class="form-control form-control-sm" name="tracking_number" value="<?php echo e($order->tracking_number); ?>" required>
                        </div>
                        <div class="form-group mb-1">
                            <label class="mb-0"><?php echo e(translate('Tracking url')); ?>:</label>
                            <input type="text" class="form-control form-control-sm" name="tracking_url" value="<?php echo e($order->tracking_url); ?>" required>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-sm btn-primary" type="submit"><?php echo e(translate('Save')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="fs-16 mb-0"><?php echo e(translate('Order updates')); ?></h3>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $order->order_udpates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order_udpate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3">
                            <div class="p-2 bg-soft-secondary rounded">
                                <?php echo e($order_udpate->translatable_note ? translate($order_udpate->note) : $order_udpate->note); ?>

                            </div>
                            <span
                                class="fs-12 opacity-60"><?php echo e(translate('by') .' ' .($order_udpate->user->name ?? translate('Deleted user')) .' at ' .$order_udpate->created_at->format('h:ia, d-m-Y')); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <!-- Refund Information Modal -->
    <div class="modal fade" id="refund_request_info_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="refund-request-info-modal-content">

            </div>
        </div>
    </div>

    
    <div id="accept_refund_request_modal" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6"><?php echo e(translate('Accept Refund Request.')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form class="form-horizontal member-block" action="<?php echo e(route('admin.refund_request.accept')); ?>"
                    method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="refund_request_id" id="refund_request_id" value="">

                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label" for="amount"><?php echo e(translate('Amount')); ?></label>
                            <div class="col-md-9">
                                <input type="number" lang="en" min="0" step="0.01" name="amount" id="amount" value=""
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <?php echo e(translate('Select Pay in Wallet to refund in the customer wallet. And select Pay Manually to refund customer manually.')); ?>

                        </div>
                        <div class="alert alert-info">
                            <?php echo e(translate('This amount is without shipping cost. If you want to add shipping cost you can change this amount.')); ?>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mt-2"
                            data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                        <button type="submit" name="button" value="manual"
                            class="btn btn-success"><?php echo e(translate('Pay Manually')); ?></button>
                        <button type="submit" name="button" value="wallet"
                            class="btn btn-primary"><?php echo e(translate('Pay in Wallet')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="reject_refund_request_modal" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6"><?php echo e(translate('Reject Refund Request.')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class='fs-14'><?php echo e(translate('Do you really want to reject this refund Request?')); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mt-2"
                        data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                    <a href="" id="reject_refund_request_link" class="btn btn-primary"><?php echo e(translate('Reject')); ?></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function() {
            var order_id = <?php echo e($order->id); ?>;
            var status = $('#update_delivery_status').val();
            $.post('<?php echo e(route('orders.update_delivery_status')); ?>', {
                _token: '<?php echo e(@csrf_token()); ?>',
                order_id: order_id,
                status: status
            }, function(data) {
                window.location.reload();
            });
        });
        $('#update_payment_status').on('change', function() {
            var order_id = <?php echo e($order->id); ?>;
            var status = $('#update_payment_status').val();
            $.post('<?php echo e(route('orders.update_payment_status')); ?>', {
                _token: '<?php echo e(@csrf_token()); ?>',
                order_id: order_id,
                status: status
            }, function(data) {
                window.location.reload();
            });
        });
        // Refund Request
        function show_refund_request_info(id) {
            $.post('<?php echo e(route('admin.refund_request.view_details')); ?>', {
                _token: '<?php echo e(@csrf_token()); ?>',
                id: id
            }, function(data) {
                $('#refund-request-info-modal-content').html(data);
                $('#refund_request_info_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }
        function accept_refund_request(id, amount) {
            $('#accept_refund_request_modal').modal('show');
            $('#refund_request_id').val(id);
            $('#amount').val(amount);
        }
        function reject_refund_request(url) {
            $('#reject_refund_request_modal').modal('show');
            document.getElementById('reject_refund_request_link').setAttribute('href', url);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/badamico/public_html/resources/views/backend/orders/show.blade.php ENDPATH**/ ?>