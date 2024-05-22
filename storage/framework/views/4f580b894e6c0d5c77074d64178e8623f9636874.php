

<?php $__env->startSection('content'); ?>

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3"><?php echo e(translate('All Sellers')); ?></h1>
        </div>
    </div>
</div>

<div class="card">
    <form class="" id="sort_sellers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6"><?php echo e(translate('Sellers')); ?></h5>
            </div>
            
            <div class="col-md-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="approved_status" id="approved_status" onchange="sort_sellers()" data-selected="<?php echo e($approved); ?>">
                    <option value=""><?php echo e(translate('Filter by Approval')); ?></option>
                    <option value="1"><?php echo e(translate('Approved')); ?></option>
                    <option value="0"><?php echo e(translate('Non-Approved')); ?></option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                  <input type="text" class="form-control" id="search" name="search" <?php if(isset($sort_search)): ?> value="<?php echo e($sort_search); ?>" <?php endif; ?> placeholder="<?php echo e(translate('Type name or phone & Enter')); ?>">
                </div>
            </div>
        </div>
    
        <div class="card-body">
           
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th data-breakpoints="lg"><?php echo e(translate('Seller info')); ?></th>
                        <th><?php echo e(translate('Shop info')); ?></th>
                        <th><?php echo e(translate('NID')); ?></th>
                        <th><?php echo e(translate('Trade Lisence')); ?></th>
                        <th><?php echo e(translate('Bank Check')); ?></th>
                       
                        <th data-breakpoints="lg"><?php echo e(translate('Current balance')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Seller Approval')); ?></th>
                        <th data-breakpoints="lg"><?php echo e(translate('Shop Published')); ?></th>
                        <th width="10%"><?php echo e(translate('Options')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    
                <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($key+1) + ($shops->currentPage() - 1)*$shops->perPage()); ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo e(uploaded_asset($shop->user->avatar ?? null)); ?>"class="size-50px rounded-circle mr-2" onerror="this.onerror=null;this.src='<?php echo e(static_asset('/assets/img/placeholder.jpg')); ?>';" />
                                <span class="flex-grow-1 minw-0">
                                    <div class="text-truncate fs-12 fw-600"><?php echo e($shop->user->name ?? translate('Deleted User')); ?></div>
                                    <div class="text-truncate fs-12"><?php echo e(translate('Phone').': '. $shop->user->phone ?? null); ?></div>
                                    <div class="text-truncate fs-12"><?php echo e(translate('Email').': '. $shop->user->email ?? null); ?></div>
                                </span>
                            </div>
                        </td>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="<?php echo e(uploaded_asset($shop->logo)); ?>"class="size-50px rounded-circle mr-2" onerror="this.onerror=null;this.src='<?php echo e(static_asset('/assets/img/placeholder.jpg')); ?>';" />
                                <span class="flex-grow-1 minw-0">
                                    <div class="text-truncate fs-12 fw-600"><?php echo e($shop->name); ?></div>
                                    <div class="text-truncate fs-12"><?php echo e(translate('Phone').': '. $shop->phone); ?></div>
                                    <div class="text-truncate fs-12"><?php echo e(translate('Total products').': '. $shop->products_count); ?></div>
                                </span>
                            </div>
                        </td>
                        <td><?php echo e($shop->nid); ?></td>
                        <td><a href="/uploads/doc/<?php echo e($shop->trade_license); ?>" download><?php echo e($shop->trade_license); ?></a></td>
                        <td><a href="/uploads/doc/<?php echo e($shop->bank_check); ?>"><?php echo e($shop->bank_check); ?></a></td>
                        <td>
                            <?php if($shop->current_balance == 0): ?>
                                <div><?php echo e(translate('Due to seller')); ?>:</div>
                                <span class="fs-16 fw-700 text-secondary"><?php echo e(format_price($shop->current_balance)); ?></span>
                            <?php elseif($shop->current_balance >= 0): ?>
                                <div><?php echo e(translate('Due to seller')); ?>:</div>
                                <span class="fs-16 fw-700 text-danger"><?php echo e(format_price($shop->current_balance)); ?></span>
                            <?php else: ?>
                                <div><?php echo e(translate('Due from seller')); ?>:</div>
                                <span class="fs-16 fw-700 text-success"><?php echo e(format_price(abs($shop->current_balance))); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="seller_approval(this)" value="<?php echo e($shop->id); ?>" type="checkbox" <?php if($shop->approval == 1): ?> checked <?php endif; ?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="shop_publish(this)" value="<?php echo e($shop->id); ?>" type="checkbox" <?php if($shop->published == 1): ?> checked <?php endif; ?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="las la-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                    <a href="#" onclick="show_seller_profile('<?php echo e($shop->user->id); ?>');"  class="dropdown-item">
                                        <?php echo e(translate('Profile')); ?>

                                    </a>
                                    <a href="#" onclick="show_seller_payment_modal('<?php echo e($shop->user->id); ?>');" class="dropdown-item">
                                        <?php echo e(translate('Pay to Seller')); ?>

                                    </a>
                                    <a href="<?php echo e(route('admin.seller_payments_history','shop_id='.$shop->id)); ?>" class="dropdown-item">
                                        <?php echo e(translate('Payment History')); ?>

                                    </a>
                                    <a href="<?php echo e(route('admin.seller.edit', encrypt($shop->user->id))); ?>" class="dropdown-item">
                                        <?php echo e(translate('Edit')); ?>

                                    </a>
                                    <a href="#" class="dropdown-item confirm-delete" data-href="<?php echo e(route('admin.seller.destroy', $shop->user->id)); ?>" class="">
                                        <?php echo e(translate('Delete')); ?>

                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="aiz-pagination">
              <?php echo e($shops->appends(request()->input())->links()); ?>

            </div>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
	<!-- Delete Modal -->
	<?php echo $__env->make('backend.inc.delete_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<!-- Seller Profile Modal -->
	<div class="modal fade" id="profile_modal">
		<div class="modal-dialog">
			<div class="modal-content" id="profile-modal-content">

			</div>
		</div>
	</div>

    <!-- Seller Payment Modal -->
	<div class="modal fade" id="payment_modal">
	    <div class="modal-dialog">
	        <div class="modal-content" id="payment-modal-content">

	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function seller_approval(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('admin.sellers.approval')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '<?php echo e(translate('Seller approval status successfully')); ?>');
                }
                else{
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }
        function shop_publish(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('admin.shop.publish')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '<?php echo e(translate('Shop publish status successfully')); ?>');
                }
                else{
                    AIZ.plugins.notify('danger', '<?php echo e(translate('Something went wrong')); ?>');
                }
            });
        }

        function show_seller_profile(id){
            $.post('<?php echo e(route('admin.sellers.profile_modal')); ?>',{_token:'<?php echo e(@csrf_token()); ?>', id:id}, function(data){
                $('#profile-modal-content').html(data);
                $('#profile_modal').modal('show', {backdrop: 'static'});
            });
        }

        function show_seller_payment_modal(id){
            $.post('<?php echo e(route('admin.sellers.payment_modal')); ?>',{_token:'<?php echo e(@csrf_token()); ?>', id:id}, function(data){
                $('#payment-modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
            });
        }

        function sort_sellers(el){
            $('#sort_sellers').submit();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/badamico/public_html/app/Addons/Multivendor/views/admin/sellers/index.blade.php ENDPATH**/ ?>