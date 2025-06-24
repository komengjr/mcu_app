<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Setting Akses</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-3" id="menu-loading-akses">
        @foreach ($data as $datas)
            @php
                $sub_menu = DB::table('z_menu_sub')->where('menu_code', $datas->menu_code)->get();
            @endphp
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" style="width: 30%;">Menu</th>
                        <th scope="col">Sub Menu</th>

                    </tr>
                </thead>
                <tbody class="fs--2">
                    <tr>
                        <td>{{ $datas->menu_name }}</td>
                        <td>
                            @foreach ($sub_menu as $item)
                                <p>{{ $item->menu_sub_name }}
                                    @php
                                        $user = DB::table('z_menu_user')
                                            ->where('menu_sub_code', $item->menu_sub_code)
                                            ->where('access_code', $code)
                                            ->first();
                                    @endphp
                                    @if ($user)
                                        <button class="btn btn-falcon-primary btn-sm float-end" id="button-setup-akses" data-number="{{$user->id_menu_user}}" data-id="{{$item->menu_sub_code}}" data-code="{{$code}}" data-status="1">Aktif</button>
                                    @else
                                        <button class="btn btn-falcon-danger btn-sm float-end" id="button-setup-akses" data-number="0" data-id="{{$item->menu_sub_code}}" data-code="{{$code}}" data-status="0">Non Aktif</button>
                                    @endif
                                </p>
                            @endforeach
                        </td>
                    </tr>

                </tbody>
            </table>
        @endforeach
    </div>
</div>
