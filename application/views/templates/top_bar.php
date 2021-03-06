<?php
/**
 * Sharif Judge online judge
 * @file top_bar.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	$(document).ready(function(){
		$("#top_bar").hoverIntent({
			over:function(){
				$(this).children(".top_menu").show();
				$(this).addClass('shj_white');
			},
			out:function(){
				$(this).children(".top_menu").hide();
				$(this).removeClass('shj_white');
			},
			selector:'.top_object.shj_menu'
		});
		$(".select_assignment").click(
			function(){
				var id = $(this).data('id');
				$.post(
					'<?php echo site_url('assignments/select') ?>',
					{
						assignment_select:id,
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
					},
					function(a) {
						if (a != "shj_failed"){
							$(".select_assignment").removeClass('checked');
							$(".i"+id).addClass('checked');
							$(".assignment_name").html($('.top_object [data-id="'+id+'"]').parents('.assignment_block').children('.assignment_item').html());
							shj.finish_time = moment(a.split(',')[0]);
							shj.extra_time = moment.duration(parseInt(a.split(',')[1],10), 'seconds');
						}
					}
				);
			}
		);
	});
</script>
<div id="top_bar">
	<div class="top_object shj_menu" id="user_top">
		<?php echo anchor('profile',$username,'id="profile_link"') ?>
		<div class="top_menu" id="user_menu">
			<a href="<?php echo site_url('profile') ?>"><div>Profile</div></a>
			<a href="<?php echo site_url('logout') ?>"><div>Logout</div></a>
		</div>
	</div>
	<?php if ($user_level >= 2): ?>

		<div class="top_object shj_menu" id="select_assignment_top">
			<a href="<?php echo site_url('assignments') ?>"><span class="assignment_name"><?php echo $assignment['name'] ?></span></a>
			<div class="top_menu" id="select_assignment_menu">
				<?php foreach($all_assignments as $item): ?>
					<div class="assignment_block">
						<div class="c1">
							<div class="select_assignment <?php echo ($item['id']==$assignment['id']?'check checked':'check') ?> i<?php echo $item['id'] ?>" data-id="<?php echo $item['id'] ?>"></div>
						</div>
						<div class="assignment_item"><?php echo $item['name'] ?></div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
        <?php endif ?>
	<div class="top_object countdown" id="countdown">
		<div class="time_block">
			<span id="time_days"></span><br>
			<span class="time_label" id="days_label"></span>
		</div>
		<div class="time_block">
			<span id="time_hours"></span><br>
			<span class="time_label" id="hours_label"></span>
		</div>
		<div class="time_block">
			<span id="time_minutes"></span><br>
			<span class="time_label" id="minutes_label"></span>
		</div>
		<div class="time_block">
			<span id="time_seconds"></span><br>
			<span class="time_label" id="seconds_label"></span>
		</div>
	</div>
	<div class="top_object countdown" id="extra_time">
		<div class="time_block">
			<span>Extra</span><br><span>Time</span>
		</div>
	</div>
	<div id="shj_logo" class="top_left">
		<a href="http://lug.nitdgp.ac.in" style="float: left; margin-left: 0px;">
			<img src="<?php echo base_url('assets/images/lug_logo.png'); ?>"/>
		</a>
		<a href="<?php echo site_url('/'); ?>" style="float: right">
			<img src="<?php echo base_url('assets/images/cc_white.png'); ?>" width="110px"/>
		</a>
	</div>
	<?php if ($user_level >= 2): ?>
	<div class="top_object shj_menu top_left" id="admin_tools_top" style="width: 60px">
		Tools
		<div class="top_menu" id="admin_tools_menu">
			<a href="<?php echo site_url('rejudge') ?>"><div>Rejudge</div></a>
			<a href="<?php echo site_url('queue') ?>"><div>Submission Queue</div></a>
			<a href="<?php echo site_url('moss/'.$assignment['id']) ?>"><div>Cheat Detection</div></a>
		</div>
	</div>
	<?php endif ?>
</div>