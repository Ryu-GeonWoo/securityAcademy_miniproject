// DOM이 로드된 후 실행되는 코드
document.addEventListener('DOMContentLoaded', function() {
    // 버튼 클릭 시 경고 메시지 표시
    const alertButton = document.getElementById('alertButton');
    if (alertButton) {
        alertButton.addEventListener('click', function() {
            alert('Button clicked!');
        });
    }

    // 폼 제출 시 경고 메시지 표시
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault(); // 폼 제출 기본 동작 방지
            alert('Form submitted!');
        });
    }
});

