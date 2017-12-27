@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ catpos($catid, ' &gt;&gt;&nbsp;&nbsp;') }}
    </div>
    <div class="blank10 clear"></div>
    <!--page-->
    <div class="helpmain">
        <div class="left">
          <div class="helpleftsite">
          <?php $Pcat = getParentData($catid); ?>
          @if($Pcat)

                <div class="title">{{ $Pcat['catname'] }}</div>
                <div class="leftbox">
                <?php $data = getCatNav($catid); ?>
                  @foreach($data as $t)
                 <a @if($t['catid']==$catid)
class="select"@endif
 href="{{ $t['url'] }}">{{ $t['catname'] }}</a>
                  @endforeach
                </div>
           @else

           <div class="title">{{ $catname }}</div>
           @endif

           </div>
        </div>
        <div class="right">
             <h2>{{ $catname }}</h2>
             <div class="clear"></div>
             <div class="notetext">
                {{ $content }}
				<!--文章内容分页 begin-->
				@if($contentpage)

				<div class="cpage">
				@foreach($contentpage as $i => $u)
				<a@if($page!=$i)
 href="{{ $u }}"@endif
>{{ $i }}</a>
				@endforeach
				</div>
				<div class="clear blank10"></div>
				@endif

				<!--文章内容分页 end-->
             </div>
        </div>
    </div>
    <!--page-->
    <div class="clear blank10"></div>
@include('footer')