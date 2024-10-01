<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../layout/header.php'; ?>
    <title>Command Injection 취약점</title>
    <link rel="stylesheet" href="/assets/css/description.css">

</head>
<body>
    <div class="container">
        <h1 class="content_title">Command Injection 취약점</h1>

        <h2>1. 정의</h2>
        <p>웹 애플리케이션에서 시스템 명령을 사용할 때, 세미콜론 혹은 <code>&, &&</code> 를 사용하여 하나의 Command를 Injection 하여 두 개의 명령어가 실행되게 하는 공격이다.</p>

        <h2>2. 발생 원인</h2>
        <p>외부 입력값을 검증하거나 제한하지 않고, 운영체제 명령어 또는 운영체제 명령어의 일부로 사용하는 경우 발생한다.</p>
        <span>※ 외부 입력값을 검증하지 않았다.</span>
        <ul>
            <li>사용자가 입력한 데이터에 대해 유효성 검사를 수행하지 않고 그대로 사용하는 경우를 의미한다.</li>
            <li>입력값에 <code>&</code>,<code>|</code>,<code>;</code> 등의 메타문자가 포함되거나 악성 명령어가 포함될 수 있다.</li>
        </ul>
        <span>※ 외부 입력값을 제한하지 않았다.</span>
        <ul>
            <li>외부 입력값을 사용할 때, 어떤 값이 허용되는지에 대한 명확한 정의와 제한을 두지 않는 경우를 의미한다.</li>
            <li>입력값에 대한 검증이나 제한이 부족하면, 공격자가 허용되지 않은 명령어나 데이터를 입력하여 시스템에 영향 줄 수 있다.</li>
        </ul>

        <h2>3. 동작 방식</h2>

        <h3>공격을 위한 충족 조건</h3>
        <ul>
            <li>시스템 셸로 전달되는 명령에 사용자 입력값 포함</li>
            <li>사용자 입력값이 이스케이프 없이 정상적으로 인식</li>
            <li>웹 애플리케이션을 구동 중인 계정에 시스템 명령 실행 권한 있는 경우</li>
        </ul>

        <h3>정상적 동작</h3>
            <img src="/assets/images/command_img_1.png" alt="정상적인 동작" width = 80%>

        <h3>악의적 동작</h3>
            <img src="/assets/images/command_img_2.png" alt="악의적인 동작" width = 80%>

        <h2>4. Command Injection 공격 위치</h2>
        <ul>
            <li>웹 애플리케이션의 사용자 입력 처리 부분</li>
            <li>서버에서 사용자의 요청을 처리하는 백엔드 코드</li>
            <li>사용자 입력을 받아 운영체제 명령어를 실행하는 스크립트나 프로그램</li>
        </ul>

        <h2>5. Command Injection 유형</h2>
            <span>직접 명령 인젝션(Direct Command Injection)</span>
                <p style="text-indent: 30px;">-  사용자가 입력한 데이터가 직접적으로 OS 명령어의 인자로 포함되어 실행되는 경우</p>

            <span>간접 명령 인젝션(Indirect Command Injection)</span>
                <p style="text-indent: 30px;">-  파일이나 환경변수를 통해 OS 명령어가 실행되는 경우</p>
                <p style="text-indent: 30px;">- 명령어가 바로 실행되는 것이 아닌 우회적인 경로로 전달되어 실행</p>

            <span>블라인드 명령 인젝션(Blind Command Injection)</span>
                <p style="text-indent: 30px;">-  사용자가 입력한 데이터가 OS 명령어에 포함되어 시스템 셸로 전달되지만, 명령어의 실행 결과가 HTTP 응답 메시지에 표시되지 않는 경우</p>
                
            <h3>특징</h3>
                <ul>
                    <li>공격자는 명령어가 성공적으로 실행되었는지 여부를 직접 확인할 수 없음</li>
                    <li>간접적인 방법으로 시스템의 동작을 관찰하며 공격을 수행</li>
                </ul>

            <h3>사용기술</h3>
                <ul>
                    <li><strong>시간지연</strong>
                        <ul>
                            <li><code>SLEEP</code>(리눅스/유닉스만 해당) 명령 또는 루프백(Loopback) <code>PING</code> 사용 가능</li>
                            <li><code>SLEEP</code> 명령이나 <code>PING</code> 명령을 통해 웹 애플리케이션의 <strong>응답 시간</strong>을 의도적으로 지연</li>
                            <li>속도 저하에는 다양한 원인이 있을 수 있으므로 <strong>반복적으로 확인 필요</strong></li>
                            <li>HTTP 응답이 의도한 만큼 일정하고 반복적으로 지연된다면 명령 인젝션 공격에 취약한 것</li>
                        </ul>
                    </li>
                    <li><strong>출력 리다이렉팅</strong>
                        <ul>
                            <li>실행 결과를 웹루트 또는 그 하위의 경로에 파일로 생성(리다이렉팅)하고 해당 파일의 URL을 통해 파일을 조회해 주입된 임의의 명령이 실행됐는지 판단하는 기술</li>
                            <li>해당 디렉토리에 대한 <strong>읽기와 쓰기 권한 필요</strong></li>
                        </ul>
                    </li>
                    <li><strong>대역 외(Out-Of-Band) 채널</strong>
                        <ul>
                            <li>취약한 서버를 공격자 또는 테스터가 제어할 수 있는 외부의 서버와 통신을 하도록 유도하고 통신 기록을 확인함으로써 주입된 임의의 명령이 실행됐는지 확인할 수 있는 기술</li>
                        </ul>
                    </li>
                </ul>

        <h2>6. 사례</h2>
        <ul>
            <li>ShellShock <a href="https://knvd.krcert.or.kr/elkDetail.do?CVEID=CVE-2014-6271&jvn=JVN55667175&CVEID=CNNVD-201409-938&dilen=60c068c3dd82393915a4b514">(CVE-2014-6271)</a></li>
            <li>ImageTragick <a href="https://knvd.krcert.or.kr/elkDetail.do?CVEID=CVE-2016-3714&jvn=&CVEID=CNNVD-201605-101&dilen=60c16cfddd82393915aec3ad">(CVE-2016-3714)</a></li>
        </ul>

        <h2>7. 실습</h2>
        <ul>
	    <li><a href="../exercise/cli/ping/ping.php">Ping.php</a></li>
	    <li><a href="../exercise/cli/file/file.php">File.php</a></li>
        </ul>

        <h2>8. 대응 방안</h2>
        <strong style="font-size:1.2em;">사용자 입력에서 시스템 명령 실행 금지</strong>
        <ul>
            <li>명령으로 전달되는 입력에 <strong>강한 입력 유효성 검사</strong> 사용<br>(특정 명령 화이트리스트 추가, 블랙리스트 추가)</li>
            <li><strong>최소 권한 사용</strong></li>
            <li>애플리케이션을 자주 업데이트하고 패치하기</li>
            <li>동적 애플리케이션 보안 테스트 도구로 애플리케이션 검사 </li>
            <li>운영체제 종류에 따른 <strong>특수문자 이스케이프 처리 또는 요청 차단</strong>
                <ul>
                    <li>윈도우: 특수문자 앞에 <code>^</code>를 추가해 이스케이프 요청 또는 차단</li>
                    <li>리눅스/유닉스: 특수문자 앞에 <code>\</code>를 추가하여 이스케이프 요청 또는 차단</li>
                </ul>
            </li>
        </ul>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>
