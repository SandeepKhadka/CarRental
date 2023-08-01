   <!-- Shop-Pagination -->
   @if ($paginator->hasPages())
       <div class="pagination-area">
           <div class="pagination-number">
               <ul>
                   @if ($paginator->onFirstPage())
                       <li class="disabled" style="display: none" aria-disabled="true" aria-label="@lang('pagination.previous')">
                           <a href="shop-v1-root-category.html" title="Previous">
                               <i class="fa fa-angle-left"></i>
                           </a>
                       </li>
                   @else
                       <li>
                           <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                               aria-label="@lang('pagination.previous')">&lsaquo;</a>
                       </li>
                   @endif
                   {{-- Pagination Elements --}}
                   @foreach ($elements as $element)
                       {{-- "Three Dots" Separator --}}
                       @if (is_string($element))
                           <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                       @endif

                       {{-- Array Of Links --}}
                       @if (is_array($element))
                           @foreach ($element as $page => $url)
                               @if ($page == $paginator->currentPage())
                                   <li class="active" aria-current="page">
                                       <a href="">{{ $page }}</a>
                                       <span></span>
                                   </li>
                               @else
                                   <li><a href="{{ $url }}">{{ $page }}</a></li>
                               @endif
                           @endforeach
                       @endif
                   @endforeach
                   {{-- Next Page Link --}}
                   @if ($paginator->hasMorePages())
                       <li>
                           <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                               aria-label="@lang('pagination.next')">&rsaquo;</a>
                       </li>
                   @else
                       <li class="disabled" style="display: none" aria-disabled="true" aria-label="@lang('pagination.next')">
                           <a href="shop-v1-root-category.html" title="Next">
                               <i class="fa fa-angle-right"></i>
                           </a>
                       </li>
                   @endif
               </ul>
           </div>
       </div>
   @endif
   <!-- Shop-Pagination /- -->
