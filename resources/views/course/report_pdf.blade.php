<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .pass {
            color: green;
        }
        .fail {
            color: red;
        }
        .not-attempted {
            color: gray;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>{{ $courseName }}</h2>
        <p>Total Points Earned: {{ $totalPointsEarned }} / {{ $totalPointsAvailable }}</p>
    </div>

    @foreach ($reportData as $chapter)
        <h3>{{ $chapter['chapter_name'] }}</h3>
        <p>Status: 
            <span class="{{ strtolower($chapter['status']) }}">{{ $chapter['status'] }}</span>
        </p>
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Your Answer</th>
                    <th>Correct Answer</th>
                    <th>Points Earned</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chapter['quizzes'] as $quiz)
                    <tr>
                        <td>{{ $quiz['question'] }}</td>
                        <td>{{ $quiz['user_answer'] }}</td>
                        <td>{{ $quiz['status'] !== 'Not Attempted' ? $quiz['correct_answer'] : 'N/A' }}</td>
                        <td>{{ $quiz['status'] !== 'Not Attempted' ? $quiz['points_earned'] : 'N/A' }}</td>
                        <td class="{{ strtolower($quiz['status']) }}">{{ $quiz['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>
