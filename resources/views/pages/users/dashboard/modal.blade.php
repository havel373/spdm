<!--begin::Modal header-->
<div class="modal-header" id="kt_modal_add_user_header">
    <!--begin::Modal title-->
    <h2 class="fw-bolder">{{$mahasiswa->id ? 'Update' :'Add'}} Project {{$mahasiswa->id ? ' ' . $mahasiswa->nama : ''}}</h2>
    <!--end::Modal title-->
    <!--begin::Close-->
    <div class="btn btn-icon btn-sm btn-active-icon-primary" onclick="$('#kt_modal_add_user').modal('hide');">
        <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
        <span class="svg-icon svg-icon-1">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                    <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                    <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                </g>
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Close-->
</div>
<!--end::Modal header-->
<!--begin::Modal body-->
<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
    <!--begin::Form-->
    <form id="kt_modal_add_user_form" class="form" action="#">
        <!--begin::Scroll-->
        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Nama Mahasiswa</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="nama" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Mahasiswa" value="{{$mahasiswa->user ? $mahasiswa->user->nama : ''}}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @if(!$mahasiswa->id)
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Email Mahasiswa</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email Mahasiswa" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Password Mahasiswa</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="password" name="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @endif
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Nim</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="nim" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nim Mahasiswa" value="{{$mahasiswa->nim}}" />
                <!--end::Input-->
            </div>
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Kelas</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" name="kelas" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Kelas Mahasiswa" value="{{$mahasiswa->kelas}}" />
                <!--end::Input-->
            </div>
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Tahun Angkatan</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="number" placeholder="YYYY" min="2000" max="2023" name="tahun" class="form-control form-control-solid mb-3 mb-lg-0" value="{{$mahasiswa->tahun}}" />
                <!--end::Input-->
            </div>
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Semester</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" placeholder="VIII" name="semester" class="form-control form-control-solid mb-3 mb-lg-0" value="{{$mahasiswa->semester}}" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fw-bold fs-6 mb-2">Prodi</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select name="prodi" class="selectpicker form-control form-control-solid mb-3 mb-lg-0" id="prodi">
                    <option value="">Pilih Prodi</option>
                    @foreach($prodis as $prodi)
                        <option value="{{$prodi->id}}" {{$prodi->id == $mahasiswa->prodi ? 'selected' : ''}}>{{$prodi->nama}}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
        </div>
        <!--end::Scroll-->
        <!--begin::Actions-->
        <div class="text-center pt-15">
            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
            <button type="button" id="button_save" onclick="handle_save_modal('#button_save','#kt_modal_add_user_form','{{$mahasiswa->id ? route('mahasiswa.update', $mahasiswa->id) : route('mahasiswa.store')}}','{{$mahasiswa->id ? 'PATCH' : 'POST'}}','#kt_modal_add_user');" class="btn btn-primary" data-kt-users-modal-action="submit">
                <span class="indicator-label">Submit</span>
                <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Form-->
</div>
<!--end::Modal body-->