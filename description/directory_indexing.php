<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../layout/header.php'; ?>
    <title>Directory Indexing 취약점</title>
    <link rel="stylesheet" href="/assets/css/description.css">
</head>
<body>
    <div class="container">
        <h1 class="content_title">Directory Indexing 취약점</h1>

        <h2>1. 정의</h2>
        <p><strong>디렉터리 인덱싱(Directory Indexing)</strong> 취약점은 웹 서버에서 특정 디렉터리의 콘텐츠가 노출되어, 해당 디렉터리의 파일 리스트가 사용자의 웹 브라우저를 통해 표시되는 보안 취약점을 의미합니다. 이를 통해 민감한 파일이나 서버의 구조가 노출될 수 있습니다.</p>

        <h2>2. 공격 방식</h2>
        <ol>
            <li><strong>디렉토리 접근 시도</strong>
                <ul>
                    <li>공격자는 웹 서버의 URL 경로를 통해 특정 디렉토리에 직접 접근을 시도합니다. </li>
                    <li>예를 들어, <code>http://example.com/admin/</code>와 같은 경로에 접근할 때, 해당 디렉토리의 인덱스 파일(index.html, index.php 등)이 존재하지 않으면 서버는 디렉토리 내의 파일 목록을 자동으로 표시할 수 있습니다.</li>
                </ul>
            </li>
            <li><strong>파일 목록 열람</strong>
                <ul>
                    <li>서버가 디렉토리 인덱싱을 활성화한 경우, 해당 디렉토리의 파일 목록이 웹 브라우저에 표시됩니다. </li>
                    <li>이 목록에는 해당 디렉토리에 존재하는 모든 파일과 서브 디렉토리가 포함되며, 파일 이름, 크기, 수정 날짜 등이 표시될 수 있습니다.</li>
                </ul>
            </li>
            <li><strong>파일 다운로드 및 열람</strong>
                <ul>
                    <li>공격자는 파일 목록에서 특정 파일을 선택하여 직접 다운로드하거나 열람할 수 있습니다. </li>
                    <li>특히, 설정 파일이나 데이터베이스 백업 파일 등 민감한 파일이 노출되면 심각한 보안 위협이 발생할 수 있습니다.</li>
                </ul>
            </li>
            <li><strong>추가 공격</strong>
                <ul>
                    <li>노출된 파일을 통해 웹 서버의 구성이나 기타 민감한 정보를 파악한 후, 추가적인 공격을 시도할 수 있습니다. </li>
                    <li>예를 들어, 파일 업로드 기능이 있는 디렉토리에 접근하여 악성 코드를 포함한 파일을 업로드하고, 이를 실행하여 서버를 장악하는 등의 2차 공격이 가능해질 수 있습니다.</li>
                </ul>
            </li>
        </ol>

        <h2>3. 보안 위협</h2>
        <ul>
            <li>공격자는 웹 서버의 특정 디렉터리와 파일 목록을 브라우저에서 직접 열람할 수 있습니다.</li>
            <li> 이를 통해 서버 구조를 파악하고, 중요한 설정 파일이나 민감한 정보가 포함된 파일이 노출될 경우 심각한 보안 위협이 발생할 수 있습니다. </li>
            <li>특히, 파일 업로드 기능과 결합하면, LFI(Local File Inclusion)를 통해 웹셸을 실행하는 등 2차 공격으로 이어질 수 있습니다.</li>
        </ul>

        <h2>4. 점검 방법</h2>
        <ul>
            <li>URL 경로 테스트: 브라우저의 주소창에 디렉터리 경로만 입력하여 인덱싱 여부를 확인합니다. 예: <code>http://example.com/admin/</code></li>
            <li>특수 문자열 사용: 디렉터리 끝에 <code>%3f.jsp</code>를 추가하여 인덱싱 페이지가 노출되는지 확인합니다. 예: <code>http://example.com/admin/%3f.jsp</code></li>
            <li>공통 디렉터리 확인: 일반적으로 사용하는 디렉터리 명칭으로 인덱싱 여부를 확인합니다. 예: <code>/icons/</code>, <code>/images/</code>, <code>/files/attach/images/</code> 등</li>
        </ul>

        <h2>5. 취약점 패치</h2>
        <h3>1. Apache 서버</h3>
        <p><code>/etc/apache2/apache2.conf</code> 파일에서 <code>Options</code> 지시어를 편집하여 <code>Indexes FollowSymLinks</code>를 삭제하거나 <code>--Indexes</code>로 변경합니다. 이후, <code>apache2</code> 서비스를 재시작하여 변경 사항을 적용합니다.</p>

        <h3>2. IIS 서버 (버전 7.0 ~ 8.0)</h3>
        <p><code>[win] + [R]</code> → 'InetMgr.exe' 실행 → [사이트] → [Default Web Site] 선택 → [Default Web Site 홈]에서 [디렉터리 검색]을 '사용 안함'으로 설정</p>

        <h3>3. Tomcat 서버</h3>
        <p><code>web.xml</code> 파일에서 <code>&lt;param-name&gt;listings&lt;/param-name&gt;</code> 설정이 <code>false</code>로 되어 있는지 확인합니다.</p>

        <h3>4. Nginx 서버</h3>
        <p><code>nginx.conf</code> 파일에서 <code>autoindex</code> 설정을 확인합니다. 만약 <code>on</code>으로 설정되어 있으면 <code>off</code>로 변경합니다.</p>


        <h2>6. 상위 디렉터리 접근 방지</h2>
        <p>디렉터리 인덱싱을 사용해야 하는 특정 디렉터리가 있는 경우, 상위 디렉터리 접근을 방지하는 추가 설정을 적용합니다.</p>

        <h2>7. 실습 </h2>
        <ul>
            <li>해당 페이지에 <strong>Directory Indexing</strong> 취약점이 있습니다.</li>
            <li>어떤 식으로 접근을 하면 해당 취약점을 이용할 수 있는지 확인해보세요.</li>
        </ul>
        <h2>8. 보안 내용</h2>
        <p><code>.git</code> 디렉터리와 같은 민감한 디렉터리 및 파일이 노출될 경우, 공격자가 웹 서버 구조를 파악하고 중요 정보를 탈취하는 등의 보안 위협이 발생할 수 있습니다. </p>
        <p>예를 들어, 아래 명령어를 사용하여 <code>.git</code> 디렉터리 전체를 다운로드할 수 있습니다:</p>

        <p>이를 방지하기 위해 디렉터리 인덱싱을 비활성화하고, <code>.git</code> 등 중요한 디렉터리에 대한 접근을 차단해야 합니다.</p>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>
