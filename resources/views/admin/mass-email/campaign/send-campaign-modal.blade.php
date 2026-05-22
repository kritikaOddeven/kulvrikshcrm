<!-- Send Campaign Modal (Reusable) -->
<div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="campaignForm">
        <div class="modal-header">
          <h5 class="modal-title" id="campaignModalLabel">Add Campaign</h5>
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
        // Select all functionality
        const selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                let checked = this.checked;
                document.querySelectorAll('.row-checkbox').forEach(cb => {
                    cb.checked = checked;
                });
                updateSelectedCount();
                toggleSendButton();
            });
        }
        // Enable/disable Send button based on selection
        document.querySelectorAll('.row-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                updateSelectedCount();
                toggleSendButton();
            });
        });

        function updateSelectedCount() {
            const count = document.querySelectorAll('.row-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = count;
        }

        function toggleSendButton() {
            let anyChecked = Array.from(document.querySelectorAll('.row-checkbox')).some(cb => cb.checked);
            let sendBtn = document.getElementById('openCampaignModal');
            if (sendBtn) sendBtn.disabled = !anyChecked;
        }
        toggleSendButton();
        updateSelectedCount();

        // Open modal on Send button click (event delegation for multiple includes)
        document.body.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'openCampaignModal') {
                let campaignModal = new bootstrap.Modal(document.getElementById('campaignModal'));
                campaignModal.show();
            }
        });

        // Initialize Flatpickr for date
        const datePicker = flatpickr("#start_date", {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: "today",
            onChange: function(selectedDates, dateStr) {
                // Update time picker's min time when date changes
                if (selectedDates[0].toDateString() === new Date().toDateString()) {
                    timePicker.set('minTime', 'now');
                } else {
                    timePicker.set('minTime', '00:00');
                }
            }
        });

        // Initialize Flatpickr for time
        const timePicker = flatpickr("#start_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minTime: "now",
            defaultHour: new Date().getHours(),
            defaultMinute: new Date().getMinutes() + 1
        });

        // Handle form submit
        document.getElementById('campaignForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate date and time
            const selectedDate = datePicker.selectedDates[0];
            const selectedTime = timePicker.selectedDates[0];
            
            if (!selectedDate || !selectedTime) {
                alert('Please select both date and time.');
                return;
            }

            // Combine date and time for validation
            const scheduledDateTime = new Date(selectedDate);
            scheduledDateTime.setHours(selectedTime.getHours(), selectedTime.getMinutes());
            
            if (scheduledDateTime < new Date()) {
                alert('Please select a future date and time.');
                return;
            }

            // Collect selected emails from checkboxes
            let selectedEmails = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                .map(cb => ({
                    email: cb.getAttribute('data-email'),
                    name: cb.getAttribute('data-name') || '',
                    id: cb.getAttribute('data-id') || '',
                    type: cb.getAttribute('data-type') || 'lead',
                    relation: cb.getAttribute('data-relation') || 'Lead'
                }));

            console.log('Selected Emails:', selectedEmails);

            if (selectedEmails.length === 0) {
                alert('Please select at least one recipient.');
                return;
            }

            let formData = new FormData(this);
            formData.append('selected_emails', JSON.stringify(selectedEmails));
            formData.append('status', 'pending'); // Set initial status
            formData.append('total_person', selectedEmails.length); // Set total recipients
            
            fetch("{{ route('admin.campaign.create') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error);
            });
        });
    });
</script>