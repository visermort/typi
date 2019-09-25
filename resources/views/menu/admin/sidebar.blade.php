@if ($sections)
    <ul class="sidebar-menu">
        @foreach ($sections as $section)
            <li class="sidebar-panel sidebar-panel-content">
                <a class="sidebar-title " href="#" data-toggle="collapse">
                    <div>{{ $section['title'] }}</div>
                </a>
                @if ($section['items'])
                    <ul class="nav-sidebar panel-collapse collapse show " id="content">
                        @foreach ($section['items'] as $item)
                            <li  class="@if (isset($item['cssClass'])){{ $item['cssClass'] }}@endif @if ('/'.$currentUrl == $item['url']) active @endif" >
                                <a href="{{ $item['url'] }}" @if (isset($item['subitem'])) class="hasAppend" @endif >
                                    @if (isset($item['icon']))<i class="icon fa {{ $item['icon'] }}"></i>@endif
                                    <div>{{ $item['title'] }}</div>
                                </a>
                                @if (isset($item['subitem']))
                                    <a class="append pull-right" href="{{ $item['subitem']['url'] }}">
                                        <i class="{{ $item['subitem']['icon']  }}"></i>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
@endif