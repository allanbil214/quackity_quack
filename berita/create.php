<?php
// ================================================================================================
// PHP INITIALIZATION & DATA FETCHING
// ================================================================================================

require_once '../helper/auth.php'; 
require_once '../helper/connection.php';

isLogin();

$categoriesQuery = mysqli_query($connection, "SELECT * FROM kategori ORDER BY nama ASC");
$tagsQuery = mysqli_query($connection, "SELECT * FROM tag ORDER BY nama ASC");
$tagSuggestions = [];
while ($tag = mysqli_fetch_assoc($tagsQuery)) {
    $tagSuggestions[] = $tag['nama'];
}
$tagSuggestionsJson = json_encode($tagSuggestions);

// ================================================================================================
// PAGE LAYOUT - TOP
// ================================================================================================

require_once '../layout/_top.php';

?>

<section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>Tambah Berita</h1>
        <a href="./index.php" class="btn btn-light">Kembali</a>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="./store.php" method="POST" enctype="multipart/form-data">
                        <table cellpadding="8" class="w-100">
                            <tr>
                                <td width="15%">Judul Berita</td>
                                <td><input class="form-control" type="text" name="judul" id="judul" size="20" required></td>
                            </tr>

                            <tr>
                                <td>Slug</td>
                                <td><input class="form-control" type="text" name="slug" id="slug" size="20" required readonly></td>
                            </tr>

                            <tr>
                                <td>Penulis</td>
                                <td>
                                    <select class="form-control" name="penulis_id_display" disabled>
                                        <option value="<?= $_SESSION['login']['id'] ?>">
                                            <?= htmlspecialchars($_SESSION['login']['name']) ?>
                                        </option>
                                    </select>
                                    <input type="hidden" name="penulis_id" value="<?= $_SESSION['login']['id'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>Kategori</td>
                                <td>
                                    <select class="form-control select2" name="kategori_id" required>
                                        <option value=""> - Pilih Kategori - </option>
                                        <?php mysqli_data_seek($categoriesQuery, 0); ?>
                                        <?php while($category = mysqli_fetch_array($categoriesQuery)): ?>
                                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['nama']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Tags</td>
                                <td>
                                    <input type="text" class="form-control tagsinput" name="tags" data-role="tagsinput" placeholder="Tambahkan tag">
                                    <small class="text-muted">Ketik tag dan tekan koma (,) untuk menambahkannya. Contoh: Berita, Teknologi, Update</small>
                                </td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    <select class="form-control" name="status" required>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Featured</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1">
                                        <label class="form-check-label" for="featured">
                                            Tampilkan di halaman utama (Harus Published)
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Gambar Utama</td>
                                <td><input class="form-control" type="file" name="gambar" accept="image/*"></td>
                            </tr>

                            <tr>
                                <td>Excerpt</td>
                                <td><textarea class="form-control" name="excerpt" rows="3" maxlength="500" placeholder="Ringkasan singkat berita (maks 500 karakter)"></textarea></td>
                            </tr>

                            <tr>
                                <td>Isi Berita</td>
                                <td colspan="3"><textarea class="form-control summernote" name="isi" id="isi" required></textarea></td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-primary" type="submit" name="proses" value="Simpan Berita">
                                    <input class="btn btn-danger" type="reset" name="batal" value="Reset Form">
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// ================================================================================================
// PAGE LAYOUT - BOTTOM
// ================================================================================================

require_once '../layout/_bottom.php';

?>

<script>
  const availableTags = <?= $tagSuggestionsJson ?>;
  if (!Array.isArray(availableTags)) {
     console.error("ERROR: availableTags is not an array!", availableTags);
  } else if (availableTags.length > 0 && typeof availableTags[0] !== 'string') {
     console.error("ERROR: availableTags does not seem to contain strings!", availableTags[0]);
  }
</script>

<script>
  document.getElementById('judul').addEventListener('input', function() {
    const title = this.value;
    let slug = title.toString().toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .replace(/\s+/g, '-')
      .replace(/[^\w\-]+/g, '')
      .replace(/\-\-+/g, '-')
      .replace(/^-+/, '')
      .replace(/-+$/, '');
    if (slug === '') { slug = 'n-a'; }
    document.getElementById('slug').value = slug;
  });
</script>

<script>
  const statusSelect = document.querySelector('select[name="status"]');
  const featuredCheckbox = document.getElementById('featured');

  function toggleFeaturedCheckbox() {
    if (statusSelect.value === 'archived' || statusSelect.value === 'draft') {
      featuredCheckbox.checked = false;
      featuredCheckbox.disabled = true;
    } else {
      featuredCheckbox.disabled = false;
    }
  }

  toggleFeaturedCheckbox();
  statusSelect.addEventListener('change', toggleFeaturedCheckbox);
</script>

<script>
 $(document).ready(function() {
    var tagsInput = $('.tagsinput');
    tagsInput.tagsinput({
        confirmKeys: [13, 44],
        trimValue: true,
    });

    tagsInput.on('itemAdded itemRemoved', function(event) {
        $(this).siblings('.bootstrap-tagsinput').find('input[type="text"]').val('');
    });

    $('.bootstrap-tagsinput input[type="text"]').autocomplete({
        source: function(request, response) {
            var term = request.term.toLowerCase();
            var matches = $.grep(availableTags, function(tag) {
                return tag.toLowerCase().indexOf(term) !== -1;
            });
            var existingTags = tagsInput.tagsinput('items');
            matches = matches.filter(function(match) {
                return existingTags.indexOf(match) === -1;
            });
            response(matches);
        },
        select: function(event, ui) {
            tagsInput.tagsinput('add', ui.item.value);
            return false;
        },
        focus: function(event, ui) {
            return false;
        },
        appendTo: '.card-body'
    });
 });
</script>

<?php
if (isset($_SESSION['info'])) :
    if ($_SESSION['info']['status'] == 'success') {
?>
    <script>
      if (typeof iziToast !== 'undefined') {
          iziToast.success({
              title: 'Sukses!',
              message: `<?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>`,
              position: 'topCenter',
              timeout: 5000
          });
      } else {
          alert('Success: <?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>');
      }
    </script>
<?php
    } else {
?>
    <script>
      if (typeof iziToast !== 'undefined') {
          iziToast.error({
              title: 'Gagal!',
              message: `<?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>`,
              timeout: 5000,
              position: 'topCenter'
          });
      } else {
          alert('Error: <?= addslashes(htmlspecialchars($_SESSION['info']['message'])) ?>');
      }
    </script>
<?php
    }
    unset($_SESSION['info']);
endif;
?>
