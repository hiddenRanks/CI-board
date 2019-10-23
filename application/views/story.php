<div class="main-board">
    <section id="board-frame">
        <div class="frame-title">
            <span>트랭글 이야기</span>
        </div>

        <div class="board-frame">
            <div>
                <span>이야기</span>
                <table class="free-board">
                    <tr class="table-head">
                        <th class="board-num">번호</th>
                        <th class="board-writer">게시자</th>
                        <th class="board-title">제목</th>
                        <th class="board-date">날짜</th>
                    </tr>

                    <?php foreach ($board->result() as $item): ?>
                        <?php if ($item->app_period == null || $item->app_period == '0000-00-00 00:00:00'): ?>
                            <tr class="table-body">
                                <td class="board-td-num"><?= $item->post_id ?></td>
                                <td class="board-td-writer"><?= $item->user_id ?></td>
                                <td class="board-td-comment">
                                    <a href="/story/view/story/post_id/<?= $item->post_id ?>">
                                        <span class="board-td-title"><?= $item->title ?></span>
                                        <span class="comment-color">
                                            <?php if ($item->comment_cnt > 0): ?>
                                                (<?= $item->comment_cnt ?>)
                                            <?php else: ?>

                                            <?php endif ?>
                                        </span>
                                    </a>
                                </td>
                                <td class="board-td-date">
                                    <?php
                                        $write = substr($item->write_date, 5, 5);
                                        if ($timestamp == $write) {
                                            echo substr($item->write_date, 11, 5);
                                        } else {
                                            echo substr($item->write_date, 5, 5);
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                </table>
            </div>

            <div>
                <span>함께가요</span>
                <table class="image-board">
                    <tr class="table-head">
                        <th class="board-num">번호</th>
                        <th class="board-writer">게시자</th>
                        <th class="board-title">제목</th>
                        <th class="board-date">날짜</th>
                    </tr>

                    <?php foreach ($board->result() as $item): ?>
                        <?php if ($item->app_period != null && $item->app_period != '0000-00-00 00:00:00'): ?>
                            <tr class="table-body">
                                <td class="board-td-num"><?= $item->post_id ?></td>
                                <td class="board-td-writer"><?= $item->user_id ?></td>
                                <td class="board-td-comment">
                                    <a href="/story/view/story/post_id/<?= $item->post_id ?>">
                                        <span class="board-td-title"><?= $item->title ?></span>
                                        <span class="comment-color">
                                            <?php if ($item->comment_cnt > 0): ?>
                                                (<?= $item->comment_cnt ?>)
                                            <?php else: ?>
                                                
                                            <?php endif ?>
                                        </span>
                                    </a>
                                </td>
                                <td class="board-td-date">
                                    <?php
                                        $write = substr($item->write_date, 5, 5);
                                        if ($timestamp == $write) {
                                            echo substr($item->write_date, 11, 5);
                                        } else {
                                            echo substr($item->write_date, 5, 5);
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </section>
</div>