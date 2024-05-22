

<?php $__env->startSection('content'); ?>

    <div class="card">
        <form class="" id="sort_payments" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6"><?php echo e(translate('All Payments')); ?></h5>
                </div>
                <div class="col-md-2 ml-auto">
                    <select id="demo-ease" class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="shop_id" onchange="sort_payments()"
                        data-selected="<?php echo e($shop_id); ?>">
                        <option value=""><?php echo e(translate('Choose Seller')); ?></option>
                        <?php $__currentLoopData = \App\Models\Shop::with('user')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($shop->user->user_type != 'admin'): ?>
                                <option value="<?php echo e($shop->id); ?>"><?php echo e($shop->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm aiz-date-range" id="search" name="date_range"<?php if(isset($date_range)): ?> value="<?php echo e($date_range); ?>" <?php endif; ?> placeholder="<?php echo e(translate('Daterange')); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary"><?php echo e(translate('Filter')); ?></button>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(translate('Seller')); ?></th>
                        <th><?php echo e(translate('Amount')); ?></th>
                        <th><?php echo e(translate('Payment Method')); ?></th>
                        <th><?php echo e(translate('Date')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $payouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo e($key+1); ?>

                            </td>
                            <td>
                                <?php echo e($payout->shop->name ?? translate('Deleted Shop')); ?>

                            </td>
                            <td>
                                <?php echo e(format_price($payout->paid_amount)); ?>

                            </td>
                            <td>
                                <?php echo e(ucfirst(str_replace('_', ' ', $payout->payment_method))); ?> <?php if($payout->txn_code != null): ?> (<?php echo e(translate('TRX ID')); ?> : <?php echo e($payout->txn_code); ?>) <?php endif; ?>
                            </td>
                            <td><?php echo e(date('d-m-Y', strtotime($payout->created_at))); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="aiz-pagination">
                <?php echo e($payouts->links()); ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function sort_payments(el) {
            $('#sort_payments').submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/badamico/public_html/app/Addons/Multivendor/views/admin/seller_payouts/payout_history.blade.php ENDPATH**/ ?>