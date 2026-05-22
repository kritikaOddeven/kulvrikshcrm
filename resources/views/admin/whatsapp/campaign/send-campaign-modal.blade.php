<!-- Send WhatsApp Campaign Modal (Reusable) -->
<div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="campaignForm">
        <div class="modal-header">
          <h5 class="modal-title" id="campaignModalLabel">Add WhatsApp Campaign</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="template_id" class="form-label">Template</label>
            <select class="form-select" id="template_id" name="template_id" required>
              <option value="">Select Template</option>
              @foreach ($templates as $template)
                <option value="{{ $template->id }}">{{ $template->template_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="text" class="form-control" id="start_date" name="start_date" required>
          </div>
          <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="text" class="form-control" id="start_time" name="start_time" required>
          </div>
          <div class="mb-3">
            <div class="alert alert-info">
              <span id="selectedCount">0</span> recipients selected
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const openCampaignModalBtn = document.getElementById('openCampaignModal');
    const selectedCountSpan = document.getElementById('selectedCount');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSendButton();
        updateSelectedCount();
    });

    // Individual checkbox functionality
    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
            updateSendButton();
            updateSelectedCount();
        });
    });

    // Update select all checkbox state
    function updateSelectAllCheckbox() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const totalBoxes = rowCheckboxes.length;
        selectAllCheckbox.checked = checkedBoxes.length === totalBoxes;
        selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalBoxes;
    }

    // Update send button state
    function updateSendButton() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        openCampaignModalBtn.disabled = checkedBoxes.length === 0;
    }

    // Update selected count
    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        selectedCountSpan.textContent = checkedBoxes.length;
    }

    // Open campaign modal
    openCampaignModalBtn.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const selectedPhones = [];

        checkedBoxes.forEach(checkbox => {
            // Get phone number - check both data-phone and data attributes
            let phone = checkbox.dataset.phone || checkbox.getAttribute('data-phone') || '';
            
            // Get phone code if available
            const phoneCode = checkbox.dataset.phonecode || checkbox.getAttribute('data-phonecode') || '';
            
            // Combine phone code with phone number if phone code exists and phone doesn't start with +
            if (phoneCode && phone && !phone.startsWith('+')) {
                // Remove any leading zeros from phone code
                const cleanPhoneCode = phoneCode.replace(/^0+/, '');
                // Ensure phone code starts with +
                const formattedPhoneCode = cleanPhoneCode.startsWith('+') ? cleanPhoneCode : '+' + cleanPhoneCode;
                phone = formattedPhoneCode + phone.replace(/^0+/, ''); // Remove leading zeros from phone
            } else if (phone && !phone.startsWith('+') && phoneCode) {
                // If phone doesn't have + but we have phonecode
                const cleanPhoneCode = phoneCode.replace(/^0+/, '');
                const formattedPhoneCode = cleanPhoneCode.startsWith('+') ? cleanPhoneCode : '+' + cleanPhoneCode;
                phone = formattedPhoneCode + phone.replace(/^0+/, '');
            } else if (phone && !phone.startsWith('+')) {
                // If no phone code but phone exists, try to add default (you might want to adjust this)
                console.warn('Phone number without country code:', phone);
            }

            selectedPhones.push({
                id: checkbox.dataset.id || checkbox.getAttribute('data-id') || '',
                phone: phone || '',
                name: checkbox.dataset.name || checkbox.getAttribute('data-name') || '',
                type: checkbox.dataset.type || checkbox.getAttribute('data-type') || '',
                relation: checkbox.dataset.relation || checkbox.getAttribute('data-relation') || ''
            });
        });

        // Validate that all selected items have phone numbers
        const phonesWithoutNumber = selectedPhones.filter(item => !item.phone || item.phone.trim() === '');
        if (phonesWithoutNumber.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Phone Numbers',
                text: `${phonesWithoutNumber.length} selected recipient(s) do not have phone numbers. Please select only recipients with valid phone numbers.`,
                confirmButtonText: 'OK'
            });
            return;
        }

        // Remove any existing hidden input
        const existingInput = document.querySelector('#campaignForm input[name="selected_phones"]');
        if (existingInput) {
            existingInput.remove();
        }

        // Store selected phones in a hidden input for form submission
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'selected_phones';
        hiddenInput.value = JSON.stringify(selectedPhones);
        document.getElementById('campaignForm').appendChild(hiddenInput);

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('campaignModal'));
        modal.show();
    });

    // Form submission
    document.getElementById('campaignForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const formObject = {};
        
        // Convert FormData to object
        formData.forEach((value, key) => {
            formObject[key] = value;
        });
        
        // Show loading
        Swal.fire({
            title: 'Creating Campaign...',
            text: 'Please wait while we create your WhatsApp campaign',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('{{ route("admin.whatsapp.campaign.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formObject)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'WhatsApp campaign created successfully!',
                    confirmButtonText: 'OK',
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error creating campaign. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while creating the campaign. Please try again.',
                confirmButtonText: 'OK'
            });
        });
    });

    // Initialize flatpickr for date and time inputs
    if (typeof flatpickr !== 'undefined') {
        flatpickr("#start_date", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
        
        flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            allowInput: true
        });
    }
});
</script> 
</script> 