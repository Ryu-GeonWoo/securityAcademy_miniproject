<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../layout/header.php'; ?>
    <title>Command Injection 취약점</title>
    <link rel="stylesheet" href="/assets/css/description.css">
</head>
<body>
    <div class="container">
        <h2>Command Injection 취약점</h2>

        <h3>1. 정의</h3>
        <p>웹 애플리케이션에서 시스템 명령을 사용할 때, 세미콜론 혹은 &, && 를 사용하여 하나의 Command를 Injection 하여 두 개의 명령어가 실행되게 하는 공격이다.</p>

        <h3>2. 발생 원인</h3>
        <ul>
            <li>사용자 입력에 대한 부적절한 검증</li>
            <li>시스템 명령에 사용자 입력을 직접 포함</li>
            <li>특수 문자나 메타 문자에 대한 부적절한 처리</li>
            <li>권한 분리의 부재</li>
        </ul>

        <h3>3. 동작 방식</h3>

        <h4>3.1 정상적 동작</h4>
        <ul>
            <li>사용자가 애플리케이션에 입력 제공</li>
            <li>애플리케이션이 입력을 처리</li>
            <li>처리된 입력을 기반으로 시스템 명령 실행</li>
            <li>실행 결과를 사용자에게 반환</li>
        </ul>

        <h4>3.2 악의적 동작</h4>
        <ul>
            <li>공격자가 악의적인 명령을 포함한 입력 제공</li>
            <li>취약한 애플리케이션이 입력을 그대로 처리</li>
            <li>악의적 명령이 포함된 시스템 명령 실행</li>
            <li>공격자가 의도한 악의적 동작 수행</li>
        </ul>

        <h3>4. 공격 당하는 위치</h3>
        <ul>
            <li>웹 애플리케이션의 서버 측 코드</li>
            <li>시스템 관리 스크립트</li>
            <li>데이터베이스 쿼리 실행 부분</li>
        </ul>

        <h3>5. 유형</h3>
        <ul>
            <li>직접 Command Injection: 공격자의 입력이 직접 명령의 일부가 됨</li>
            <li>간접 Command Injection: 공격자의 입력이 파일이나 환경 변수를 통해 간접적으로 명령에 영향을 줌</li>
            <li>Blind Command Injection: 실행 결과가 직접 보이지 않지만, 시간 지연 등을 통해 명령 실행 여부를 추측할 수 있음</li>
        </ul>

        <h3>6. 사례</h3>
        <ul>
            <li>ShellShock (CVE-2014-6271)</li>
            <li>ImageTragick (CVE-2016-3714)</li>
            <li>PHP</li>
        </ul>

        <h3>7. 실습</h3>
        <ul>
            <li>Ping.php</li>
        </ul>

        <h3>8. 대응 방안</h3>
        <ul>
            <li>입력 검증 및 필터링: 특수 문자 및 메타 문자 제거 또는 이스케이프</li>
            <li>매개변수화된 쿼리 사용: 동적 쿼리 대신 준비된 구문 사용</li>
            <li>최소 권한 원칙 적용: 애플리케이션에 필요한 최소한의 권한만 부여</li>
            <li>출력 인코딩: 사용자에게 반환되는 데이터의 적절한 인코딩</li>
            <li>보안 업데이트: 시스템과 라이브러리의 정기적인 업데이트</li>
        </ul>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>
