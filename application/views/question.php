<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
	<h1 class="text-center">Questions!</h1>
	<form method="POST" action="<?php echo base_url('AuthController/logout'); ?>" class="d-flex justify-content-end w-75">
		<button type="submit">Logout</button>
	</form>

	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#question_modal">
		Add Question
	</button>

	<div class="modal fade" id="question_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_label">Add Question</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="add_question_form">
						<label for="question">Question</label>
						<input name="question" id="question" required>
						<br>
						<input class="btn btn-primary" type="submit">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="d-flex justify-content-center align-items-center">
		<table>
			<tr>
				<th class="border-1 p-3">No</th>
				<th class="border-1 p-3">Question</th>
				<th class="border-1 p-3">Answers</th>
				<th class="border-1 p-3">Actions</th>
			</tr>
			<?php foreach($questions as $question){ ?>
				<tr data-id="<?php echo $question['question_id']; ?>">
					<td class="border-1 p-3">
						<?php echo $question['question_id']; ?>
					</td>
					<td class="border-1 p-3">
						<?php echo $question['question_title']; ?>
					</td>
					<td class="border-1 p-3">
						<ul>
							<li>
								<?php echo $question['answer_title']; ?>
								<?php echo $question['is_correct'] ? '<i class="bi bi-hand-thumbs-up"></i>' : ''; ?>
							</li>
						</ul>
					</td>
					<td class="d-flex flex-row border-1 p-4 gap-1">
						<button class="btn-delete btn btn-danger" data-id="<?php echo $question['question_id']; ?>">Delete</button>
						<form method="POST">
							<input type="submit" value="Edit">
						</form>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script>
		document.getElementById('add_question_form').addEventListener('submit', function (e) {
			e.preventDefault()

			const question = document.getElementById('question').value
			const formData = new FormData()
			formData.append('question', question)

			const modal_element=document.getElementById('question_modal')
			const modal=bootstrap.Modal.getOrCreateInstance(modal_element)
			modal.hide()
			document.getElementById('add_question_form').reset()

			

			fetch('<?php echo base_url('question/store'); ?>', {
				method: 'POST',
				body: formData,
			})
		})

		document.addEventListener('DOMContentLoaded',()=>{
			const buttons=document.querySelectorAll('.btn-delete');

			buttons.forEach(button => {
					button.addEventListener('click',function(){
						console.log('button pressed')
						const id=this.getAttribute('data-id')
						const row=document.querySelector(`tr[data-id="${id}"]`)

						fetch('<?php echo base_url('question/delete'); ?>',{
							method:'POST',
							headers: {
								'Content-Type': 'application/x-www-form-urlencoded',
							},
							body:`question_id=${id}`
						})
						row.remove()
					})
				})
			})
	</script>
	</body>
</html>
