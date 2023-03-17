import "../css/app.scss";

document.addEventListener('DOMContentLoaded', () => {
    new App();
})

class App{
    constructor() {
        this.handleCommentForm();
    }

    handleCommentForm() {
        const commentForm = document.querySelector('form.comment-form')
        if (null === commentForm) {
            return;
        }

     
        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const reponse = await fetch('/ajax/comments', {
                method: 'POST',
                body: new FormData(e.target)

            })

            if (!reponse.ok) {
                return;
            }
            const json = await reponse.json();
            if (json.code === "COMMENT_ADDED_SUCCESSFULLY") {
                const commentList = document.querySelector('.comment-list');
                const commentCount = document.querySelector('#comment-count');
                const commentContent = document.querySelector('#comment-content');
                commentList.insertAdjacentHTML('afterbegin', json.message);
                commentCount.innerHTML = json.nomberOfComments;
                commentContent.value = ''
            }
        })

        

    }
}