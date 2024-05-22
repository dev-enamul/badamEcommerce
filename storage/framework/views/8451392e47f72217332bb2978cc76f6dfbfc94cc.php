

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6"><?php echo e(translate('Offline Wallet Recharge Requests')); ?></h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo e(translate('Name')); ?></th>
                    <th><?php echo e(translate('Amount')); ?></th>
                    <th><?php echo e(translate('Method')); ?></th>
                    <th><?php echo e(translate('TXN ID')); ?></th>
                    <th><?php echo e(translate('Receipt')); ?></th>
                    <th><?php echo e(translate('Approval')); ?></th>
                    <th><?php echo e(translate('Date')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($wallet->user != null): ?>
                        <tr>
                            <td><?php echo e(($key+1)); ?></td>
                            <td><?php echo e($wallet->user->name); ?></td>
                            <td><?php echo e($wallet->amount); ?></td>
                            <td><?php echo e($wallet->payment_method); ?></td>
                            <td><?php echo e($wallet->payment_details); ?></td>
                            <td>
                                <?php if($wallet->reciept != null): ?>
                                    <a href="<?php echo e(my_asset($wallet->reciept)); ?>" target="_blank"><?php echo e(translate('Open Reciept')); ?></a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input 
                                        <?php if(auth()->user()->can('approve_offline_wallet_recharge') && $wallet->approval == 0): ?>
                                            onclick="update_approved('<?php echo e(route('offline_recharge_request.approved', $wallet->id )); ?>')"
                                        <?php endif; ?>
                                        type="checkbox" 
                                        <?php if($wallet->approval == 1): ?> checked disabled <?php endif; ?> 
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('approve_offline_wallet_recharge')): ?> disabled <?php endif; ?> >
                                        <span class="slider round"></span>
                                </label>
                            </td>

                            <td><?php echo e($wallet->created_at); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="aiz-pagination">
            <?php echo e($wallets->links()); ?>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<div id="payment-approval-modal" class="modal fade">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6"><?php echo e(translate('Offline Wallect Recharge Confirmation')); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <i class="la la-4x la-warning text-warning mb-4"></i>
                <p class="fs-18 fw-600 mb-1"><?php echo e(translate('Are you sure to approve this?')); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal"><?php echo e(translate('Cancel')); ?></button>
                <a href="" id="approve-link" class="btn btn-primary mt-2"><?php echo e(translate('Yes, Approve')); ?></a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function update_approved(url){
            $("#payment-approval-modal").modal("show");
            $("#approve-link").attr("href", url);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/badamico/public_html/resources/views/backend/manual_payment_methods/wallet_request.blade.php ENDPATH**/ ?>