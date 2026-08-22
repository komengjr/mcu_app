<form id="mcuDynamicFormContent">
    @csrf
    <input type="hidden" name="id_mcu_form" value="{{ $form->id_mcu_form }}">
    <input type="hidden" name="user_code" value="{{ $userCode }}">

    <!-- Styling Tambahan untuk Form Modal Modern -->
    <style>
        .mcu-header-card {
            background: linear-gradient(135deg, #ffffff 0%, #fff5f6 100%);
            border-left: 4px solid #E60026 !important;
            box-shadow: 0 4px 15px rgba(230, 0, 38, 0.05);
        }

        .mcu-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .mcu-item-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(180deg, #FF3355 0%, #E60026 100%);
            opacity: 0.6;
            transition: all 0.25s ease;
        }

        .mcu-item-card:hover {
            transform: translateY(-2px);
            border-color: #fca5a5 !important;
            box-shadow: 0 8px 20px rgba(230, 0, 38, 0.08) !important;
        }

        .mcu-item-card:hover::before {
            opacity: 1;
            width: 5px;
        }

        .number-badge {
            background: linear-gradient(135deg, #FF3B5C 0%, #C80022 100%);
            color: #ffffff;
            font-weight: 700;
            width: 26px;
            height: 26px;
            font-size: 0.75rem;
            box-shadow: 0 3px 8px rgba(200, 0, 34, 0.3);
        }

        .mcu-custom-input:focus {
            border-color: #ff4d6d !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 51, 85, 0.15) !important;
            background-color: #fff !important;
        }

        .mcu-radio-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 14px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .mcu-radio-card:has(input:checked) {
            background-color: #fff0f2;
            border-color: #ff4d6d;
            color: #c80022;
            font-weight: 600;
        }

        .btn-vibrant-save {
            background: linear-gradient(135deg, #FF3B5C 0%, #E60026 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(230, 0, 38, 0.25);
            transition: all 0.2s ease;
        }

        .btn-vibrant-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(230, 0, 38, 0.35);
            color: #ffffff;
        }
    </style>

    <!-- Header Form -->
    <div class="mcu-header-card p-3 mb-3 rounded-3 border">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6 class="fw-bold text-900 mb-1 d-flex align-items-center">
                    <span class="badge rounded-pill bg-danger-subtle text-danger me-2 p-1 fs--2">
                        <i class="fas fa-file-medical"></i>
                    </span>
                    {{ $form->form_name }}
                </h6>
                <p class="text-600 mb-0 fs--2">{{ $form->description ?? 'Silakan lengkapi formulir pemeriksaan di bawah ini.' }}</p>
            </div>
            <span class="badge bg-light text-700 border fs--2 px-2 py-1 rounded-pill">
                <i class="fas fa-list-check text-danger me-1"></i> {{ count($items) }} Item
            </span>
        </div>
    </div>

    <!-- Container Loop Item -->
    <div class="row g-2">
        @forelse($items as $item)
        @php
        $currentAnswer = $answers[$item->id_mcu_form_item] ?? '';
        @endphp

        <div class="col-12">
            <!-- Card Item Pemeriksaan Modern -->
            <div class="card mcu-item-card shadow-none">
                <div class="card-body p-3">

                    <div class="d-flex align-items-start gap-2 mb-2">
                        <!-- Badge Nomor Gradient -->
                        <span class="number-badge rounded-circle d-inline-flex align-items-center justify-content-center flex-shrink-0">
                            {{ $loop->iteration }}
                        </span>

                        <!-- Label Item -->
                        <label class="form-label fw-bold text-800 fs--1 mb-0 pt-1">
                            {{ $item->item_label }}
                            @if($item->is_required)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                    </div>

                    <!-- Input Fields Area -->
                    <div class="ps-4 ms-2">
                        <!-- Input Text / Number -->
                        @if(in_array($item->field_type, ['text', 'number']))
                        <div class="input-group input-group-sm">
                            <input type="{{ $item->field_type }}"
                                name="answers[{{ $item->id_mcu_form_item }}]"
                                class="form-control form-control-sm mcu-custom-input"
                                value="{{ $currentAnswer }}"
                                placeholder="Ketik {{ strtolower($item->item_label) }}..."
                                {{ $item->is_required ? 'required' : '' }}>
                            @if($item->unit)
                            <span class="input-group-text fs--2 bg-light fw-semibold text-600">{{ $item->unit }}</span>
                            @endif
                        </div>

                        <!-- Input Textarea -->
                        @elseif($item->field_type == 'textarea')
                        <textarea name="answers[{{ $item->id_mcu_form_item }}]"
                            class="form-control form-control-sm mcu-custom-input"
                            rows="2"
                            placeholder="Tuliskan catatan atau keterangan detail..."
                            {{ $item->is_required ? 'required' : '' }}>{{ $currentAnswer }}</textarea>

                        <!-- Input Yes / No (Radio Card Toggle) -->
                        @elseif($item->field_type == 'yes_no')
                        <div class="d-flex align-items-center gap-2 pt-1">
                            <label class="mcu-radio-card d-flex align-items-center gap-2 mb-0 fs--1" for="radio_yes_{{ $item->id_mcu_form_item }}">
                                <input class="form-check-input mt-0"
                                    type="radio"
                                    name="answers[{{ $item->id_mcu_form_item }}]"
                                    id="radio_yes_{{ $item->id_mcu_form_item }}"
                                    value="Ya"
                                    {{ $currentAnswer == 'Ya' ? 'checked' : '' }}
                                    {{ $item->is_required ? 'required' : '' }}>
                                <span>Ya</span>
                            </label>
                            <label class="mcu-radio-card d-flex align-items-center gap-2 mb-0 fs--1" for="radio_no_{{ $item->id_mcu_form_item }}">
                                <input class="form-check-input mt-0"
                                    type="radio"
                                    name="answers[{{ $item->id_mcu_form_item }}]"
                                    id="radio_no_{{ $item->id_mcu_form_item }}"
                                    value="Tidak"
                                    {{ $currentAnswer == 'Tidak' ? 'checked' : '' }}
                                    {{ $item->is_required ? 'required' : '' }}>
                                <span>Tidak</span>
                            </label>
                        </div>

                        <!-- Input Select / Dropdown -->
                        @elseif($item->field_type == 'select')
                        <select name="answers[{{ $item->id_mcu_form_item }}]" class="form-select form-select-sm mcu-custom-input" {{ $item->is_required ? 'required' : '' }}>
                            <option value="">-- Pilih Hasil --</option>
                            <option value="Normal" {{ $currentAnswer == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Abnormal" {{ $currentAnswer == 'Abnormal' ? 'selected' : '' }}>Abnormal</option>
                        </select>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-4">
            <div class="p-4 rounded-3 bg-light border border-dashed">
                <i class="fas fa-folder-open fa-2x text-300 mb-2"></i>
                <p class="text-600 fs--1 mb-0 fw-semibold">Belum ada item isian pada formulir ini.</p>
            </div>
        </div>
        @endforelse
    </div>
</form>
