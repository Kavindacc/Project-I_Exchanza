document.getElementById('openPanel').addEventListener('click', function() {
    document.getElementById('sidePanel').style.right = '0';
});

document.getElementById('closePanel').addEventListener('click', function() {
    document.getElementById('sidePanel').style.right = '-250px';
});
  
function showForm() {
    document.getElementById('popupForm').style.display = 'block';
}

document.getElementById('closePopup').addEventListener('click', function() {
    document.getElementById('popupForm').style.display = 'none';
});

$(document).ready(function() {
    // Update preview function
    function updatePreview() {
        $('#previewName').text($('#itemName').val());
        $('#previewPrice').text('Rs. ' + $('#price').val());
        $('#previewDescription').text($('#description').val());
        $('#previewCategory').text($('#category option:selected').text());
        $('#previewSubcategory').text($('#subcategory option:selected').text());
        $('#previewTimesUsed').text('Times Used: ' + $('#timesUsed').val());
        var selectedSize = $('input[name="size"]:checked').val();
        $('#previewSize').text(selectedSize ? 'Size: ' + selectedSize : '');
    }

    // Category change event
    $('#category').change(function() {
        var category = $(this).val();
        var showSubcategory = ['women', 'men', 'kids'].includes(category);
        $('#subcategoryWrapper').toggleClass('hidden', !showSubcategory);
        $('#sizeChartWrapper').addClass('hidden');
        $('#subcategory').val('');
        updatePreview();
    });
    
    // Subcategory change event
    // ||'dresses'||'t-shirts'||'shirts'||'suits'||'clothes'
    $('#subcategory').change(function() {
        var subcategory = $(this).val();
    
        $('#normalsizeChartWrapper, #pantssizeChartWrapper, #shoessizeChartWrapper').addClass('hidden');
        $('#normalsizeChartWrapper input[type="radio"], #pantssizeChartWrapper input[type="radio"], #shoessizeChartWrapper input[type="radio"]').prop('checked', false);
    
        // if (subcategory === 't-shirts') 
        if (['t-shirts', 'tops', 'dresses', 'shirts', 'suits','clothes'].includes(subcategory)) {
            $('#normalsizeChartWrapper').removeClass('hidden');
        } else if (subcategory === 'pants') {
            $('#pantssizeChartWrapper').removeClass('hidden');
        } else if (subcategory === 'shoes') {
            $('#shoessizeChartWrapper').removeClass('hidden');
        }
        updatePreview();
    });
   

    // Input and change events
    $('#itemName, #price, #description, #timesUsed').on('input', function() {
        updatePreview();
    });

    $('#color').change(function() {
        $('#previewName').css('color', $(this).val());
    });

    $('#coverImage').change(function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('input[name="size"]').change(function() {
        updatePreview();
    });

    // Form validation
    $('#resellForm').submit(function(event) {
        var form = this;
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});

