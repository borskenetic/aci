@php
    /**
     * Expects:
     * - $frameworkFields (Collection<CatalogFrameworkField> with marcField loaded)
     * - $marcValues (array) optional for edit
     */
    $marcValues = $marcValues ?? [];
@endphp

<div class="row g-3" id="marcEditor">
    @foreach($frameworkFields as $ff)
        @php
            $mf = $ff->marcField;
            if (!$mf) continue;
            $tag = $mf->tag;
            $subKey = $mf->subfield ?? '_';
            $display = $tag . ($mf->subfield ? " ‡{$mf->subfield}" : "");
            $values = $marcValues[$tag][$subKey] ?? [];
            if (!is_array($values)) $values = [];
            ksort($values);
            $values = array_values($values);
            if (count($values) === 0) {
                $values = [$ff->default_value ?? ''];
            }
        @endphp

        <div class="col-md-6 marc-field" data-tag="{{ $tag }}" data-sub="{{ $subKey }}" data-repeatable="{{ $mf->repeatable ? '1' : '0' }}">
            <label class="form-label">
                {{ $display }}
                @if($mf->label)
                    <span class="text-muted">— {{ $mf->label }}</span>
                @endif
            </label>

            <div class="marc-values d-grid gap-2">
                @foreach($values as $idx => $val)
                    @php $name = "marc[{$tag}][{$subKey}][]"; @endphp

                    @if($mf->input_type === 'textarea')
                        <textarea name="{{ $name }}" class="form-control" rows="2">{{ old("marc.$tag.$subKey.$idx", $val) }}</textarea>
                    @elseif($mf->input_type === 'select')
                        <select name="{{ $name }}" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach(($mf->options ?? []) as $opt)
                                @php $optVal = is_array($opt) ? ($opt['value'] ?? '') : $opt; @endphp
                                @php $optLabel = is_array($opt) ? ($opt['label'] ?? $optVal) : $opt; @endphp
                                <option value="{{ $optVal }}" {{ old("marc.$tag.$subKey.$idx", $val) == $optVal ? 'selected' : '' }}>
                                    {{ $optLabel }}
                                </option>
                            @endforeach
                        </select>
                    @elseif($mf->input_type === 'date')
                        <input type="date" name="{{ $name }}" class="form-control" value="{{ old("marc.$tag.$subKey.$idx", $val) }}">
                    @else
                        <input type="text" name="{{ $name }}" class="form-control" value="{{ old("marc.$tag.$subKey.$idx", $val) }}">
                    @endif
                @endforeach
            </div>

            @if($mf->repeatable)
                <button type="button" class="btn btn-sm btn-secondary mt-2 marc-add-value">Add another</button>
            @endif

            @error("marc.$tag.$subKey")
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    @endforeach
</div>

@push('scripts')
<script>
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.marc-add-value');
    if (!btn) return;
    const field = btn.closest('.marc-field');
    const valuesWrap = field.querySelector('.marc-values');
    const last = valuesWrap.querySelector('input, textarea, select');
    if (!last) return;

    const clone = last.cloneNode(true);
    if (clone.tagName === 'SELECT') {
      clone.selectedIndex = 0;
    } else {
      clone.value = '';
    }
    valuesWrap.appendChild(clone);
    clone.focus();
  });
</script>
@endpush

