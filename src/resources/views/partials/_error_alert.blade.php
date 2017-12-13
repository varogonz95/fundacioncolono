<script>
	$(document).ready(function () {
		swal({
			title: "{{ session('status')['title'] }}",
			icon: "{{ session('status')['type'] }}",
			text: "{{ session('status')['msg'] }}",
			buttons: {{ session('status')['type'] === 'error' ? 'true' : 'false' }},
			{{ session('status')['type'] === 'error' ? '' : 'timer: 3500' }}
		});
	});
</script>