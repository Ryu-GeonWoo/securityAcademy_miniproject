<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../layout/header.php'; ?>
    <title> File Download 취약점</title>
    <link rel="stylesheet" href="/assets/css/description.css">

</head>
<body>
    <div class="container">
        <h1 class="content_title">File Download 취약점</h1>

        <h2>1. 정의</h2>
        <p>파일 다운로드 기능 사용 시 임의의 문자나 주요 파일의 입력을 통해 웹 서버의 홈 디렉터리를 벗어나 임의의 위치에 있는 파일을 다운 가능한 취약점(passwd, 중요파일/백업, 데이터베이스, 소스코드 정보 등)</p>

        <h2>2. 발생 원인</h2>
        <li>파일 다운로드 시 파일의 절대경로 또는 상대 경로가 노출되는 경우</li>
        <li>다운로드 모듈이 파일의 경로나 이름을 파라미터로 사용하는 경우</li>
        <li>파일 경로와 파일명 필터링 미흡 (ex. ../ 를 사용해 상위 디렉토리 접근)</li>
        <li>다운로드 경로가 노출되지 않더라도 구조가 단순하여 파라미터 변조를 통해 접근이 허용되지 않는 파일에 접근 가능할 경우</li>

        <h2>3. 동작 방식</h2>

        <img src="/assets/images/fd_img_1.png" alt="동작 방식" width = 90%>
        <li>CASE 1: filename에 파일명을 입력 받는 경우</li>
        <ul>
            <img src="/assets/images/fd_img_2.png" alt="CASE 1" width = 90%>
            <li>경로 이동 문자를 삽입하여 지정된 경로가 아닌 다른 파일을 다운로드</li>
        </ul>
        <li>CASE 2: 일부 경로와 파일명을 입력 받는 경우, 2가지 방법</li>
        <ul>
            <img src="/assets/images/fd_img_3.png" alt="CASE 2" width = 90%>
            <li>일부 경로를 받는 곳에 이동 문자를 삽입</li>
            <li>파일명에 경로 이동 문자를 삽입</li>
        </ul>
        <li>CASE 3: 전체 경로가 나오는 경우</li>
        <ul>
            <img src="/assets/images/fd_img_4.png" alt="CASE 3" width = 90%>
            <li>원하는 경로와 파일을 입력</li>
            <li>가장 취약한 경우</li>
        </ul><br>
        <li>특정 단어(/,\ 등)이 필터링이 설정되어 있는 경우</li>
        <ul>
			<li>인코딩 방식, ASCII 활용</li>
          <b>URL 인코딩 ("/" => %2F, "\" => %5C, "." => %2E)</b><br>
          ex)
          <ul>
            <li><code> /../../../../../etc/passwd</code></li>
            <li><code>%2F..%2F..%2F..%2F..%2F..%2Fetc%2Fpasswd</code></li>
            <li><code>%2f%2e%2e%2f%2e%2e%2f%2e%2e%2f%2e%2e%2f%2e%2e%2f%65%74%63%2f%70%61%73%73%77%64</code></li>
          </ul>
        </ul>

        <h2>4. 중요 정보 파일</h2>
        <h3>리눅스</h3>
        <ul>
            <li><span>/var/log/message</span> => 시스템 메시지 로그</li>
            <li><span>/etc/service</span> => 서비스 정보</li>
            <li><span>/etc/passwd</span> => 시스템 유저 계정 리스트</li>
            <li><span>/etc/shadow</span> => 계정 패스워드 파일</li>
            <li><span>/etc/hosts</span> => 호스트 이름과 IP 주소 맵핑</li>
            <li><span>~./bash_history </span>=> 사용자 명령어 기록</li>
            <li><span>/etc/sysconfig</span> => 시스템과 네트워크 설정 파일</li>
        </ul>
        <h3>윈도우</h3>
        <ul>
            <li><span>C:\Windows\System32\winevt\Logs</span> => 서비스 로그들이 위치한 폴더</li>
            <li><span>C:\Windows\System32\config</span> => 레지스트리 정보가 저장된 파일들이 위치한 폴더</li>
            <li><span>C:\Windows\System32\config\SOFTWARE</span> => 윈도우 및 소프트웨어 전역 설정 정보</li>
            <li><span>C:\Windows\System32\config\SYSTEM</span> => 시스템 전역 설정 정보</li>
            <li><span>C:\Windows\System32\config\SECURITY</span> => 권한, 인증 도메인 등의 보안 관련 정보</li>
            <li><span>C:\Windows\System32\config\SAM</span> => 사용자들의 암호화된 비밀번호 저장소</li>
        </ul>

        <h2>5. 위험성</h2>
            <li>공격자가 파일 다운로드 시 파라미터를 조작하여 웹 사이트의 중요한 파일(DB 커넥션 파일, 애플리케이션 파일 등) 또는 웹 서버 루트에 있는 중요한 설정 파일(passwd, shadow 등)을 다운 받을 수 있음</li>
            <li><span>cgi, jsp, php</span> 등 파일 다운로드 기능을 제공해주는 애플리케이션에서 입력되는 경로를 검증하지 않는 경우 웹 서버의 홈 디렉터리를 벗어나서 임의의 위치에 있는 파일을 열람하거나 다운받는 것이 가능</li>
            <li>공격자가 시스템 중요 정보(계정 정보, 데이터베이스 정보) 등을 탈취하여 시스템 침투에 중요한 정보를 확인할 수 있음</li>

        <h2>6. 사례</h2>
        <ul>
            <li><a href="https://knvd.krcert.or.kr/elkDetail.do?CVEID=CVE-2023-20077&jvn=&CVEID=CNNVD-202305-1752&dilen=646692dd8a0cd3955be4c010">CVE-2023-20077</a></li>
            <p><span>Cisco ISE(Identity Services Engine)</span>의 웹 기반 관리 인터페이스에 있는 여러 취약점으로 인해 인증된 원격 공격자가 영향을 받는 장치의 파일 시스템에서 임의의 파일을 다운로드 가능</p>
            <li><a href="https://knvd.krcert.or.kr/elkDetail.do?CVEID=CVE-2020-7846&jvn=&CVEID=CNNVD-202102-1579&dilen=60c1affedd82393915b3f497">CVE-2020-7846</a></li>
            <p>v10.0 이전의 Helpcom에는 하드 코딩 된 암호화 키 저장으로 인한 파일 다운로드 및 실행 취약성이 포함</p>
        </ul>

        <h2>7. 대응 방안</h2>
        <ul>
            <li>파일 이름과 경로명을 데이터베이스에서 관리 및 비교</li>
            <li>특정 디렉터리에서만 다운로드가 가능하도록 설정</li>
            <li>다운로드 경로를 사용자가 확인할 수 없게 제한</li>
            <li><code>./\%</code>와 같은 특수문자를 필터링 처리</li>
        </ul>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>
