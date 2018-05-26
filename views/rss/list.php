<div class="container">
	<h1>RSS</h1>
	<p>
	<br/><b>RSS là gì?</b>
<br/>
	<br/>RSS (Really Simple Syndication) Dịch vụ cung cấp thông tin cực kì đơn giản. Dành cho việc phân tán và khai thác nội dung thông tin Web từ xa (ví dụ như các tiêu đề, tin tức). Sử dụng RSS, các nhà cung cấp nội dung Web có thể dễ dàng tạo và phổ biến các nguồn dữ liệu ví dụ như các link tin tức, tiêu đề, và tóm tắt.
<br/>
	<br/>Một cách sử dụng nguồn kênh tin RSS được nhiều người ưa thích là kết hợp nội dung vào các nhật trình Web (weblogs, hay "blogs"). Blogs là những trang web mang tính các nhân và bao gồm các mẩu tin và liên kết ngắn, thường xuyên cập nhật.
<br/>
	<br/><b>Danh mục tin RSS mà thieunien.abc cung cấp</b>
<br/>
	<br/>thieunien.abc hiện tại cung cấp các nguồn kênh dữ liệu dưới đây theo định dạng chuẩn mới nhất RSS 2.0. Các nguồn kênh tin này là miễn phí cho việc sử dụng dưới mục đích cá nhân và phi lợi nhuận. Bạn chỉ việc copy và dán các địa chỉ URL này vào những trang web hoặc phần mềm hỗ trợ đọc tin từ RSS Feeds hoặc kéo thả biểu tượng RSS dưới đây vào các phần mềm hỗ trợ RSS là được.
	</p>
	<div class="row">
			<div class="col-md-4">
				<p><a href="/rss/0/tin-moi.rss"><img style="width: 20px;" src="/frontend/img/rss.png"> Tin mới nhất</a></p>
			</div>	
			<?php foreach($categoryList as $category){?>
				<div class="col-md-4">
					<p><a href="/rss/<?=$category->id?>/<?=$category->slug?>.rss"><img style="width: 20px;" src="/frontend/img/rss.png"> <?=$category->name?></a></p>
				</div>
			<?php }?>
		
	</div>

</div>