@php
    $idCheckBox = str_random(6);
@endphp
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" v-model="isShowMap" id="{{ $idCheckBox }}">
                <label class="form-check-label" for="{{ $idCheckBox }}">
                    Lựa chọn vị trí trên bản đồ
                    (Nếu bạn chọn ô này hãy kéo map sao cho mũi tên di chuyển tới vị trí bạn cần đánh dấu là xong)
                </label>
            </div>
        </div>
        <div v-show="isShowMap">
                <gmap-map
                    :center="mapCenter"
                    :zoom="14"
                    map-type-id="roadmap"
                    style="width: 100%; height: 440px"
                    @center_changed="mapUpdateCenter"
                    @idle="syncMap"
                >
                    <gmap-marker :position="reportedMapCenter" />
                </gmap-map>
        </div>
    </div>
</div>