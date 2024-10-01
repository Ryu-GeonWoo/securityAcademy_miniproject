<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include '../layout/header.php'; ?>
    <title>SQL Injection 취약점</title>
    <link rel="stylesheet" href="/assets/css/description.css">
    <link rel="stylesheet" href="/assets/css/description_table.css">
</head>
<body>
    <div class="container">
        <h1 class="content_title">SQL Injection 취약점</h1>

        <h2>1. 정의</h2>
        <p><strong>SQL Injection</strong>은 공격자가 웹 애플리케이션의 입력 필드를 통해 악의적인 SQL 구문을 삽입하여, 데이터베이스를 조작하거나 민감한 정보를 획득할 수 있는 취약점이다.</p>

        <h2>2. 발생 원인</h2>
        <ul>
            <li>사용자 입력을 신뢰하여 SQL 쿼리를 직접 구성</li>
            <li>SQL 쿼리 내에서 입력값에 대한 유효성 검증 및 필터링 미흡</li>
            <li>매개변수화된 쿼리나 준비된 문(statement)을 사용하지 않음</li>
        </ul>

        <h2>3. 동작 방식</h2>

        <h3>3.1 정상적 동작</h3>
        <img src="/assets/images/sqli-1.png" alt="정상적인 로그인 요청" width = 800px>
        <ul>
            <li>사용자가 로그인 폼에 자신의 ID와 비밀번호를 입력</li>
            <li>웹 애플리케이션이 해당 정보를 사용해 데이터베이스에서 일치하는 사용자를 조회</li>
            <li>조회된 사용자 정보에 따라 인증이 성공적으로 처리됨</li>
        </ul>

        <h3>3.2 악의적 동작</h3>
        <img src="/assets/images/sqli-2.png" alt="비정상적인 로그인 요청" width = 800px>
        <ul>
            <li>공격자가 로그인 폼에 악의적인 SQL 구문을 입력</li>
            <li>웹 애플리케이션이 해당 입력값을 신뢰하여 SQL 쿼리를 직접 실행</li>
            <li>데이터베이스에서 불법적인 데이터 조회, 데이터 수정, 삭제 등의 명령이 실행됨</li>
        </ul>

        <h2>4. 관리자 계정 로그인 예시</h2>
        <img src="/assets/images/sqli-3.png" alt="관리자 로그인 예시" width = 800px>
        <ul>
            <li>총 3개의 조건식이 존재
                <table>
                    <thead>
                        <tr>
                            <th>구분</th>
                            <th>내용</th>
                            <th>조건의 참/거짓 여부</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>조건식 1</td>
                            <td>id= ‘admin’</td>
                            <td>TRUE<br>admin 계정이 있다고 가정했으므로 참이 됨</td>
                        </tr>
                        <tr>
                            <td>조건식 2</td>
                            <td>‘1’=’1’</td>
                            <td>TRUE<br>1=1은 항상 성립</td>
                        </tr>
                        <tr>
                            <td>조건식 3</td>
                            <td>password = ‘anything’</td>
                            <td>FALSE<br>admin 계정의 정확한 비밀번호가 아님</td>
                        </tr>
                    </tbody>
                </table>
            </li>
            <li>AND연산자 우선 순위는 OR 연산자 보다 높음</li>
            <li>즉, admin 계정의 패스워드 없이 로그인에 성공하게 됨</li>
        </ul>

        <h2>5. 취약점의 영향</h2>
        <ul>
            <li><span>데이터 유출</span>: 데이터베이스에서 민감한 정보를 불법적으로 조회할 수 있음</li>
            <li><span>데이터 변조</span>: 데이터베이스의 데이터를 수정하거나 삭제할 수 있음</li>
            <li><span>인증 우회</span>: 공격자가 관리자의 권한으로 로그인할 수 있음</li>
            <li><span>서비스 중단</span>: 악의적인 쿼리로 인해 데이터베이스에 과부하를 초래하여 서비스가 중단될 수 있음</li>
        </ul>

        <h2>6. 유형</h2>
        <ol>
            <li><strong>Error-based SQL 인젝션</strong>
                <ul>
                    <li>잘못된 문법이나 자료형 불일치 등에 의해 웹 브라우저에 표시되는 데이터베이스 오류를 기반으로 수행되는 공격 기법</li>
                    <li>쿼리의 출력을 볼 수 없지만, 오류 메시지는 볼 수 있는 경우 사용 됨</li>
                    <li>주로 데이터베이스에 대한 정보를 획득하기 위해 사용됨</li>
                </ul>
            </li>
            <li><strong>Union-based SQL 인젝션</strong>
                <ul>
                    <li>웹 애플리케이션이 백엔드 데이터베이스로 질의한 SQL 쿼리의 결과가 HTTP 응답에 표시될 때 이 SQL 쿼리를 조작하여 데이터베이스 구조 및 데이터베이스에 저장된 민감한 데이터를 획득하기 위해 사용되는 기법</li>
                    <li><span>UNION</span> 또는 <span>UNION ALL</span>을 이용해 원래의 SQL 쿼리에 민감한 데이터를 추출하는 SQL 쿼리를 덧붙힘으로써 공격 가능 함</li>
                    <li>기존의 데이터 조회를 조작하여 출력하지 않도록 하고 <span>UNION ALL</span>을 통해서 원하는 데이터만 출력할 수 도 있음</li>
                </ul>
            </li>
            <li><strong>Blind SQL 인젝션</strong>
                <ul>
                    <li>사용자의 입력이 SQL 쿼리로 해석되기는 하나 웹 애플리케이션이 HTTP 응답에 어떠한 데이터나 데이터베이스 오류 메시지를 전혀 표시하지 않을 때 사용됨</li>
                    <li>SQL 쿼리의 결과가 참 또는 거짓이냐에 따른 규칙적인 HTTP 응답의 차이를 기반으로 공격을 수행</li>
                    <li>특정 컬럼의 문자 첫 번째부터 하나 씩 모든 문자와 비교하며 최종적으로 모든 문자 추론 가능함, 얻은 문자를 조합해 원하는 데이터 획득 가능</li>
                    <li><span>Boolean</span>과 <span>Time</span> 기반 기법이 주로 사용됨</li>
                </ul>
            </li>

        </ol>
        <h2>7. 사례</h2>
        <ul>
            <li><a href="https://www.boho.or.kr/kr/bbs/view.do?bbsId=B0000302&nttId=66742&menuNo=205023">CVE-2021-26633</a></li>
        </ul>

        <h2>8. 실습</h2>
        <ul>
        <li><a href="/exercise/sqli/sqli_find_user.php">Find User</a></li>
        <li><a href="/exercise/login/login_page.php">Login</a></li>
        </ul>

        <h2>9. 대응 방안</h2>
        <ul>
            <li><span>매개변수화된 쿼리</span> 사용: 사용자 입력값을 직접 쿼리에 포함시키지 않고, 매개변수를 사용하여 쿼리를 작성</li>
            <li><span>입력값 검증</span>: 입력값에 대해 길이, 형식 등을 검증하고, 예상 범위를 벗어나는 값을 필터링</li>
            <li><span>ORM 사용</span>: 객체-관계 매핑(Object-Relational Mapping) 도구를 사용하여 쿼리 생성을 자동화하고 SQL Injection을 방지</li>
            <li><span>최소 권한 원칙 적용</span> : 데이터베이스 계정에 최소한의 권한만 부여하여 피해를 최소화</li>
            <li><span>오류 메시지 제한</span> : 데이터베이스 관련 오류 메시지가 사용자에게 노출되지 않도록 제한</li>
            <li><span>정기적인 보안 점검</span> : 웹 애플리케이션과 데이터베이스의 보안 취약점을 정기적으로 점검</li>
        </ul>
    </div>

    <?php include '../layout/footer.php'; ?>
</body>
</html>
