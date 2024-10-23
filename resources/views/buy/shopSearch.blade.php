<style>
    .input-group form {
        margin-bottom: 20px; /* Memberikan margin bawah untuk memisahkan dengan elemen lain */
    }

</style>

<div class="input-group w-100 mx-auto d-flex">
    <form action="{{ url('shop_search') }}" method="get" class="d-flex align-items-center">
        @csrf
        <input type="search" name="search" class="form-control p-3 me-2" placeholder="Cari...">
        <button type="submit" class="btn btn-primary p-3" style="background-color: #FFE7C9!important">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
