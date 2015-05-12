		<footer class="motopress-wrapper footer">
			<div class="container">
				<div  class="row">
					<div class="col-md-3 col-sm-3 col-xs-6 footer_div" >
						<h2 class="text-center">Служба поддержки</h2>
						<a href="tel:89999887083">8 999 988 70 83</a>
						<a href="">Вопросы и ответы</a>
						<a href="">Уход за изделиями</a>
						<a href="">Доставка</a>
						<a href="">Взять в кредит</a>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 footer_div">
						<h2 class="text-center">Новинки и новости</h2>
						<a href="">Подписаться на нашу рассылку</a>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6 footer_div">
						<h2 class="text-center">Наша компания</h2>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-6  footer_div">
						<h2 class="text-center">Контакты</h2>
						<a href="mail:contact@diadelle.ru">contact@diadelle.ru</a>
					</div>
				</div>	
			</div>
		</footer>
		<!--End #motopress-main-->
	</div>
	<div id="back-top-wrapper" class="visible-desktop">
		<p id="back-top">
			<a href="#top"><span></span></a>
		</p>
	</div>
	<?php if(of_get_option('ga_code')) { ?>
		<script type="text/javascript">
			<?php echo stripslashes(of_get_option('ga_code')); ?>
		</script>
		<!-- Show Google Analytics -->
	<?php } ?>
	<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->
</body>
</html>