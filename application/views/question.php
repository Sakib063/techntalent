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
					</form>
					<form id="add_answer_form">
						<div id="answer_fields">
							<div class="answer_group">
								<label for="title_0">Answer</label>
								<input type="text" id="title_0" name="title[]" class="form-control" required>
								<br>
								<label for="is_correct_0">Is Correct?</label>
								<input id="is_correct_0" type="checkbox" name="is_correct[]" class="form-check-input">
								<br>
							</div>
						</div>
						<button type="button" id="add_more_fields" class="btn btn-secondary my-2">Add Another Answer</button>
					</form>
					<button class="btn btn-primary" id="submit_all">Submit</button>
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
			<tbody id="questions_table_body">

			</tbody>
		</table>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script>
		document.addEventListener('DOMContentLoaded',()=>{
			fetch_questions()

			let count = 1
			document.getElementById('add_more_fields').addEventListener('click',function () {
				const add_answer_group = document.createElement('div')
				add_answer_group.classList.add('answer_group')

				add_answer_group.innerHTML = `
				  <label for="title_${count}">Answer</label>
				  <input id="title_${count}" name="title[]" class="form-control" required>
				  <br>
				  <label for="is_correct_${count}">Is Correct?</label>
				  <input id="is_correct_${count}" type="checkbox" name="is_correct[]" class="form-check-input">
				  <br>
				`
				document.getElementById('answer_fields').appendChild(add_answer_group)

				count++
			})

			document.getElementById('submit_all').addEventListener('click',function(e){
				e.preventDefault()

				const question = document.getElementById('question').value
				let formData = new FormData()
				formData.append('question', question)

				const modal_element=document.getElementById('question_modal')
				const modal=bootstrap.Modal.getOrCreateInstance(modal_element)

				fetch('<?php echo base_url('question/store'); ?>', {
					method: 'POST',
					body: formData,
				}).then(response => response.json())
				.then(data=>{
					const question_id=data
					const titles=document.getElementsByName('title[]')
					const is_correct=document.getElementsByName('is_correct[]')

					for(let i=0;i<titles.length;i++){
						formData = new FormData()
						formData.append('question_id',question_id)
						console.log(titles[i].value)
						formData.append('answer_title',titles[i].value)
						formData.append('is_correct',is_correct[i].checked ? 1 : 0)
						fetch('<?php echo base_url('answer/store'); ?>', {
							method: 'POST',
							body: formData,
						}).then(()=>fetch_questions())
					}
					modal.hide()
					document.getElementById('add_question_form').reset()
					document.getElementById('add_answer_form').reset()
				})
			})
		})


		function delete_handler(){
			const buttons=document.querySelectorAll('.btn-delete');

			buttons.forEach(button => {
				button.addEventListener('click',function(){
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
		}

		function fetch_questions() {
			fetch('<?php echo base_url('question/fetch'); ?>')
				.then((response) => response.json())
				.then((data) => {
					console.log(data)
					const tableBody = document.getElementById('questions_table_body');
					tableBody.innerHTML = '';

					let counter = 1;
					for (const questionId in data) {
						const question = data[questionId];

						let answersHtml = question.answers
							.map(
								(answer) => `
                                    <div>
                                        ${answer.answer_title} ${
									answer.is_correct ? '<i class="bi bi-hand-thumbs-up"></i>' : ''
								}
                                    </div>
                                    <hr>
                                `
							)
							.join('');

						tableBody.innerHTML += `
                            <tr data-id="${questionId}">
                                <td class="border-1 p-3">${counter++}</td>
                                <td class="border-1 p-3">${question.question_title}</td>
                                <td class="border-1 p-3">${answersHtml}</td>
                                <td class="border-1 p-3">
                                    <button class="btn-delete btn btn-danger mb-1" data-id="${questionId}">Delete</button>
                                    <form method="POST">
                                        <input type="submit" value="Edit">
                                    </form>
                                </td>
                            </tr>
                        `;
					}

					delete_handler();
				});
		}

	</script>
	</body>
</html>
