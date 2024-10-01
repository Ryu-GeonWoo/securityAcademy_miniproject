<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../layout/header.php'; ?>
    <title>File Upload 취약점</title>
    <link rel="stylesheet" href="/assets/css/description.css">
</head>
<body>
    <div class="container">
        <h1 class="content_title">File Upload 취약점</h1>

        <h2>1. 정의</h2>
        <p>파일 업로드 기능이 존재하는 웹 상에서, 서버에서 실행될 수 있는 스크립트 파일(asp, jsp, php 등)이 업로드 되어 실행될 수 있는 취약점이다. </p>

        <h2>2. 발생 원인</h2>
        <ul>
            <li>파일이 업로드되기 전에 유효성 검사가 구현되지 않음</li>
            <li>안전하지 않은 방식으로 구현된 유효성 검사</li>
            <li>파일에 대한 필터링 조치 미흡</li>
        </ul>

        <h2>3. 동작 방식</h2>

        <h3>3.1 정상적 동작</h3>
        <ul>
            <li>사용자가 자신의 프로필 화면에서 사진 파일(jpeg,png)을 업로드</li>
            <li>해당 사진 파일은 웹 루트 하위의 profile 디렉토리에 저장됨</li>
            <li>웹 애플리케이션은 URL을 통해 사진 파일이 저장된 위치에서 파일을 가져와 프로필 조회 화면에 포함시킴</li>
            
        </ul>

        <h3>3.2 악의적 동작</h3>
        <ul>
            <li>공격자가 이미지 파일이 아니라 스크립팅 언어로 된 웹셸 파일을 업로드</li>
            <li>해당 웹셸 파일은 웹 루트 하위의 profile 디렉토리에 저장됨</li>
            <li>공격자는 서버에 저장된 웹셸 파일을 웹 브라우저에서 열람하거나 임의의 명령 실행</li>
            <li>시스템 손상 혹은 다른 공격에 필요한 시스템 정보 파악 가능</li>
        </ul>

        <h2>4. 취약점의 영향</h2>
        <ul>
            <li>원격 명령 실행: 웹셸 업로드를 통해 원격 명령 실행이 가능하고 시스템의 민감한 정보를 획득하거나 시스템을 완전히 손상시킬 수 있다.</li>
            <li>보안 우회: 서버 내부의 중요한 파일(.htaccess와 같은 파일)과 동일한 이름의 파일을 업로드하여 해당 파일을 덮어씀으로써 기존 보안 설정을 무력화하고 다른 공격을 시도할 수 있다.</li>
            <li>피싱 공격: 기존 파일을 피싱 페이지로 덮어쓸 경우 해당 페이지를 방문한 사용자는 피싱 공격에 노출된다.</li>
            <li>서비스 중단: 대용량 파일이 업로드 될 경우 이를 처리하기 위해 서버 자원이 고갈되고 서비스는 의도치 않게 중단될 수 있다. </li>
            <li>클라이언트측 공격: 악성 스크립트가 포함된 파일, 악성 파일(멀웨어) 등이 업로드될 경우 해당 파일은 사용자의 계정을 탈취하거나 컴퓨터를 감염 또는 손상시킬 수 있다. </li>
        </ul>

        <h2>5. 유형</h2>
        <p>파일 업로드 취약점은 웹 애플리케이션 서버에 악성 파일을 저장시키는 형태에 따라 두 가지 유형으로 구분된다.</p>

        <ul>
            <li>로컬 파일 업로드: 웹 애플리케이션 자체내에서 사용자가 직접 악성 파일을 업로드할 수 있는 취약점</li>
            <li>원격 파일 업로드: 웹 애플리케이션 자체에서 사용자가 직접 파일을 업로드할 수는 없으나 인터넷상에 존재하는 악성 파일의 URL을 통해 원격 파일을 요청하게 하여 웹 애플리케이션 서버 내부에 저장할 수 있는 취약점</li>
           
        </ul>

        <h2>6. 사례</h2>
        <ul>
            <li><a href="https://knvd.krcert.or.kr/elkDetail.do?CVEID=CVE-2024-39717&jvn=&CVEID=&dilen=66c7a7d3f80b7b647c8cb7d9">CVE-2024-39717</a></li>
            <li><a href="https://cybersecuritynews.com/apache-struts-2-vulnerability/">Hackers are Actively Exploiting Apache Struts 2 Vulnerability</a></li>
            <li><a href="https://www.boho.or.kr/kr/bbs/view.do?bbsId=B0000302&nttId=67124&menuNo=205023">CVE-2021-26642</a></li>
        </ul>

        <h2>7. 실습</h2>
        <ul>
        <li><a href="../exercise/upload.php">upload.php</a></li>
        <li><a href="../exercise/upload-base64.php">upload-base64.php</a></li>
        </ul>

        <h2>8. 대응 방안</h2>
        <ul>
            <li>파일 확장자 검증: 안전한 파일 확장자만 업로드를 허용하는 화이트리스트 방식의 필터를 적용</li>
            <li>파일 유형 검증: 허용할 MIME TYPE을 정하고 업로드되는 파일의 Content-Type 헤더값이 허용된 MIME TYPE 목록에 포함되는지 검사</li>
            <li>파일 Magic Number 검증: 안전한 매직 넘버를 선별하고 업로드되는 파일의 매직 넘버가 허용 목록에 포함된 매직 넘버인지 검사하고 안전한 파일인 경우에만 업로드를 허용</li>
            <li>파일명 길이 및 파일 용량 제한: 업로드되는 파일명의 길이와 파일 용량의 크기 제한</li>
            <li>파일명 변경 또는 난독화: 파일 업로드 처리 시 파일명을 변경하거나 난독화</li>
            <li>웹 루트 상위에 .htaccess 파일 저장: .htaccess 파일은 공격자가 접근할 수 없는 웹 루트 상위 디렉토리에 저장해야 하고, .htaccess 라는 이름의 파일을 업로드할 수 없도록 필터링을 구현</li>
            <li>악성 파일 여부 검사: 파일을 서버에 저장하기 전에 안티바이러스 소프트웨어를 통해 악성 파일 여부를 검사하고 안전한 경우에만 허용</li>
            <li>업로드 파일 저장 위치의 분리: 업로드된 파일을 원격 파일 서버나 별도의 디스크 파티션에 저장</li>
        </ul>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>
