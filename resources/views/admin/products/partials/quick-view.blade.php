{{-- admin/products/partials/quick-view.blade.php --}}
<div class="quick-view-modal" id="quickViewModal">
    <div class="quick-view-content">
        <button class="quick-view-close" onclick="closeQuickView()">
            <i class="fas fa-times"></i>
        </button>
        <img src="" alt="" id="quickViewImage">
        <div class="quick-view-info">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span style="font-size: 9px; letter-spacing: 2px; text-transform: uppercase; background: #1A1A1A; color: #FFF; padding: 3px 10px; font-weight: 600;" id="quickViewTag"></span>
            </div>
            <h3 style="font-weight: 700; font-size: 18px; color: #1A1A1A; margin-bottom: 8px;" id="quickViewName"></h3>
            <p style="font-size: 12px; color: #777; line-height: 1.5; margin-bottom: 12px;" id="quickViewDesc"></p>
            <div style="display: flex; gap: 12px;">
                <span style="font-weight: 600; font-size: 14px; color: #1A1A1A; background: rgba(26,26,26,0.06); padding: 6px 14px;" id="quickViewPrice"></span>
                <span style="font-size: 11px; color: #999; padding: 6px 0;" id="quickViewCategory"></span>
            </div>
        </div>
    </div>
</div>
