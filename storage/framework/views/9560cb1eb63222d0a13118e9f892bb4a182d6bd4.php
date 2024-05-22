

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="chat_list" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6"><?php echo e(translate('Chat List')); ?></h5>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(translate('Customer')); ?></th>
                            <th data-breakpoints="md"><?php echo e(translate('Last Message')); ?></th>
                            <th class="text-right"><?php echo e(translate('Options')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $chat_threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chat_thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(($key+1) + ($chat_threads->currentPage() - 1)*$chat_threads->perPage()); ?></td>
                                <td>
                                    <?php echo e(optional($chat_thread->customer)->name); ?>

                                </td>
                                <td>
                                    <span><?php echo e($chat_thread->chats()->latest()->first()->message); ?></span> <br>
                                    <span class="fs-10 opacity-60"><?php echo e(Carbon\Carbon::parse($chat_thread->last_message_at)->diffForHumans()); ?></span>
                                </td>
                                <td class="text-right">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show_messages')): ?>
                                        <a href="<?php echo e(route('chats.show', $chat_thread->id)); ?>" class="btn btn-sm btn-icon btn-circle btn-soft-primary" title="<?php echo e(translate('Show')); ?>">
                                            <i class="las la-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="aiz-pagination aiz-pagination-center">
                    <?php echo e($chat_threads->appends(request()->input())->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/badamico/public_html/resources/views/backend/chats/index.blade.php ENDPATH**/ ?>