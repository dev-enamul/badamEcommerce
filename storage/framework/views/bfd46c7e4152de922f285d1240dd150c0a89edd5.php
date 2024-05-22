

<?php $__env->startSection('content'); ?>

    <div class="card">
        <form class="" id="sort_orders" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6"><?php echo e(translate('Orders')); ?></h5>
                </div>
                <div class="col-xl-2 col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker" name="payment_status" onchange="sort_orders()"
                        data-selected="<?php echo e($payment_status); ?>">
                        <option value=""><?php echo e(translate('Filter by Payment Status')); ?></option>
                        <option value="paid"><?php echo e(translate('Paid')); ?></option>
                        <option value="unpaid"><?php echo e(translate('Unpaid')); ?></option>
                    </select>
                </div>

                <div class="col-xl-2 col-md-3">
                    <select class="form-control aiz-selectpicker" name="delivery_status" onchange="sort_orders()"
                        data-selected="<?php echo e($delivery_status); ?>">
                        <option value=""><?php echo e(translate('Filter by Deliver Status')); ?></option>
                        <option value="order_placed"><?php echo e(translate('Order placed')); ?></option>
                        <option value="confirmed"><?php echo e(translate('Confirmed')); ?></option>
                        <option value="processed"><?php echo e(translate('Processed')); ?></option>
                        <option value="shipped"><?php echo e(translate('Shipped')); ?></option>
                        <option value="delivered"><?php echo e(translate('Delivered')); ?></option>
                        <option value="cancelled"><?php echo e(translate('Cancelled')); ?></option>
                    </select>
                </div>
                <div class="col-md-2 ml-auto">
                    <select id="demo-ease" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="shop_id" onchange="sort_orders()"
                        data-selected="<?php echo e($shop_id); ?>">
                        <option value=""><?php echo e(translate('Choose Shop')); ?></option>
                        <?php $__currentLoopData = \App\Models\Shop::with('user')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($shop->user->user_type != 'admin'): ?>
                                <option value="<?php echo e($shop->id); ?>"><?php echo e($shop->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-xl-2 col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" <?php if(isset($sort_search)): ?>
                            value="<?php echo e($sort_search); ?>" <?php endif; ?>
                            placeholder="<?php echo e(translate('Type Order code & hit Enter')); ?>">
                    </div>
                </div>
            </div>
        </form>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(translate('Shop')); ?></th>
                        <th><?php echo e(translate('Order Code')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Num. of Products')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Customer')); ?></th>
                        <th><?php echo e(translate('Amount')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Delivery Status')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Payment Status')); ?></th>
                        <th data-breakpoints="lg" class="text-right" width="15%"><?php echo e(translate('options')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo e($key + 1 + ($orders->currentPage() - 1) * $orders->perPage()); ?>

                            </td>
                            <td>
                                <?php echo e($order->shop->name ?? translate('Deleted Shop')); ?>

                            </td>
                            <td>
                                <div><?php echo e(translate('Package')); ?> <?php echo e($order->code); ?> <?php echo e(translate('of')); ?></div>
                                <div class="fw-600"><?php echo e($order->combined_order->code); ?></div>
                            </td>
                            <td>
                                <?php echo e(count($order->orderDetails)); ?>

                            </td>
                            <td>
                                <?php echo e($order->user->name ?? translate('Deleted Customer')); ?>

                            </td>
                            <td>
                                <?php echo e(format_price($order->grand_total)); ?>

                            </td>
                            <td>
                                <span
                                    class="text-capitalize"><?php echo e(translate(str_replace('_', ' ', $order->delivery_status))); ?></span>
                            </td>
                            <td>
                                <?php if($order->payment_status == 'paid'): ?>
                                    <span class="badge badge-inline badge-success"><?php echo e(translate('Paid')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-inline badge-danger"><?php echo e(translate('Unpaid')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_orders')): ?>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="<?php echo e(route('orders.show', $order->id)); ?>" title="<?php echo e(translate('View')); ?>">
                                        <i class="las la-eye"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoice_download')): ?>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        title="<?php echo e(translate('Print Invoice')); ?>" href="javascript:void(0)"
                                        onclick="print_invoice('<?php echo e(route('orders.invoice.print', $order->id)); ?>')">
                                        <i class="las la-print"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoice_download')): ?>
                                    <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        href="<?php echo e(route('orders.invoice.download', $order->id)); ?>"
                                        title="<?php echo e(translate('Download Invoice')); ?>">
                                        <i class="las la-download"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_orders')): ?>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="<?php echo e(route('orders.destroy', $order->id)); ?>"
                                        title="<?php echo e(translate('Delete')); ?>">
                                        <i class="las la-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="aiz-pagination">
                <?php echo e($orders->appends(request()->input())->links()); ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('backend.inc.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function sort_orders(el) {
            $('#sort_orders').submit();
        }

        function print_invoice(url) {
            var h = $(window).height();
            var w = $(window).width();
            window.open(url, '_blank', 'height=' + h + ',width=' + w + ',scrollbars=yes,status=no');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/badamico/public_html/app/Addons/Multivendor/views/admin/seller_orders.blade.php ENDPATH**/ ?>