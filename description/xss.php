<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../layout/header.php'; ?>
    <title>XSS 취약점</title>
    <link rel="stylesheet" href="/assets/css/description.css">
    <link rel="stylesheet" href="/assets/css/description_table.css">
</head>
<body>
    <div class="container">
        <h1 class="content_title">XSS 취약점</h1>

        <h2>1. 정의</h2>
        <p><strong>XSS </strong>은 클라이언트 사이드 취약점 중 하나로, 공격자가 웹 리소스에 악성 스크립트를 삽입해 이용자의 웹 브라우저에서 해당 스크립트를 실행하여 공격자가 해당 취약점을 통해 특정 계정의 세션 정보를 탈취하고 해당 계정으로 임의의 기능을 수행할 수 있는 취약점이다.</p>
        
        <table>
            <thead>
                <tr>
                    <th>종류</th>
                    <th>설명</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Stored XSS</td>
                    <td>XSS에 사용되는 악성 스크립트가 서버에 저장되고 서버의 응답에 담겨오는 XSS</td>
                </tr>
                <tr>
                    <td>Reflected XSS</td>
                    <td>XSS에 사용되는 악성 스크립트가 URL에 삽입되고 서버의 응답에 담겨오는 XSS</td>
                </tr>
                <tr>
                    <td>DOM-based XSS</td>
                    <td>XSS에 사용되는 악성 스크립트가 URL Fragment에 삽입되는 XSS<br>- Fragment는 서버 요청/응답 에 포함되지 않는다.                    </td>
                </tr>
                <tr>
                    <td>Universal XSS</td>
                    <td>클라이언트의 브라우저 혹은 브라우저의 플러그인에서 발생하는 취약점으로 SOP 정책을 우회하는 XSS</td>
                </tr>
            </tbody>
        </table>


        <h2>2. 발생 원인</h2>
        <ul>
            <li>XSS 공격은 이용자가 삽입한 내용을 출력하는 기능에서 발생한다.</li>
            <li>클라이언트는 HTTP 형식으로 웹 서버에 리소스를 요청하고 서버로부터 받은 응답, 즉 HTML, CSS, JS 등 웹 리소스를 시각화하여 이용자에게 보여준다.</li>
            <li>이 때, HTML, CSS, JS와 같은 코드가 포함된 게시물을 조회할 경우 이용자는 변조된 페이지를 보거나 스크립트가 실행될 수 있다.</li>
        </ul>

        <h2>3. 공격 방식</h2>
        <p>취약한 웹 사이트를 조작해 사용자에게 악성 자바스크립트를 반환하는 방식으로 동작</p>
        <img src="/assets/images/xss-1.png" alt="xss 예시" width = 800px>

        <h3>보안 위협 영향</h3>
        <ul>
            <li>세션 쿠키 탈취를 통한 계정 도용</li>
            <li>가짜 로그인 페이지를 통한 자격증명 탈취 및 도용</li>
            <li>민감한 데이터 유출</li>
            <li>웹 사이트에 트로이 목마 기능 주입 가능</li>
        </ul>

        <h2>4. 점검 방법</h2>
        <p>대부분의 XSS 취약점은 Burp Suite의 웹 취약점 스캐너를 사용해 찾아낼 수 있음</p>
        <ul>
            <li><strong>Stored XSS 및 Reflected XSS</strong>
                <ul>
                    <li>일반적으로 애플리케이션의 모든 진입점이 간단한 고유 입력을 제출</li>
                    <li>제출된 입력이 HTTP 응답에서 반환되는 모든 위치를 식별하고, 각 위치를 개별적으로 테스트해 XSS가 발생하는 컨텍스트를 확인 가능</li>
                </ul>
            </li>
        </ul>

        <h2>5. 대응 방안</h2>
        <ul>
            <li>사용자 입력값 검증 - HTML 태그나 자바스크립트 등에서 사용될 수 있는 특수문자를 안전한 문자로 치환하거나 차단</li>
            <li>올바른 데이터 출력값 처리 - 이스케이프 또는 인코딩 사용</li>
            <li>쿠키에 HttpOnly 플래그 설정</li>
            <li>CSP(Content Security Policy) 적용</li>
            <li>응답페이지에 올바른 MIME TYPE 설정</li>
            <li>웹 방화벽 구축</li>
        </ul>

        <h2>6. 사례</h2>
        <ul>
            <li><a href="https://cybersecuritynews.com/cisco-finesse-vulnerabilities/">CVE-2024-20404 및 CVE-2024-20405 취약점</a></li>
            <li><a href="https://www.helpnetsecurity.com/2024/02/13/cve-2023-43770/">CVE-2023-43770</a></li>
        </ul>

        <h2>8. 실습</h2>
        <ul>
        <li><a href="/exercise/xss.php">xss</a></li>
        <li><a href="/exercise/xss_stored/list.php">xss_stored</a></li>
        </ul>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>
