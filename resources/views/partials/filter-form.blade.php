<form id="filterForm" action="{{ route('databarang.index') }}" method="GET" class="hidden">
    <input type="hidden" name="search" value="{{ request('search') }}">
    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
    <input type="hidden" name="kondisi" value="{{ request('kondisi') }}">
    <input type="hidden" name="lokasi" value="{{ request('lokasi') }}">
    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
</form>
