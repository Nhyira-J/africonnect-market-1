// Helper: AJAX action
function ajaxAction(url, data, callback) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(res => res.json())
        .then(callback)
        .catch(err => {
            console.error('AJAX Error:', err);
            alert('Network error. Please try again.');
        });
}

// UPDATE USER - using row-based data collection
function updateUserRow(button) {
    const row = button.closest('tr');
    const userId = row.dataset.userId;
    const fullName = row.dataset.fullName;
    const email = row.querySelector('.user_email').value.trim();
    const userType = row.querySelector('.user_type').value;

    if (!email || !userType) {
        alert('Please fill in all fields.');
        return;
    }

    ajaxAction('../actions/update_user_action.php', {
        user_id: parseInt(userId),
        full_name: fullName,
        email: email,
        user_type: userType
    }, res => {
        if (res.success) {
            alert('User updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + res.message);
        }
    });
}

// DELETE USER - using row-based data collection
function deleteUserRow(button, userName) {
    const row = button.closest('tr');
    const userId = row.dataset.userId;

    if (confirm(`Are you sure you want to delete user "${userName}"? This action cannot be undone.`)) {
        ajaxAction('../actions/delete_user_action.php', {
            user_id: parseInt(userId)
        }, res => {
            if (res.success) {
                alert('User deleted successfully!');
                location.reload();
            } else {
                alert('Error: ' + res.message);
            }
        });
    }
}
