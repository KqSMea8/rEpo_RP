<form name="form1" class="logForm" action="login.php" method="post"  enctype="multipart/form-data">

                        <div class="form-group">
                            <label><?= EMAIL_ADDRESS ?><span class="red">*</span></label>
                            <input type="text" name="LoginEmail" id="LoginEmail" class="form-control"  placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label><?= PASSWORD ?><span class="red">*</span></label>
                            <input type="password" name="LoginPassword" id="LoginPassword" class="form-control"  placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="Remember" value="Yes">
                                <?= REMBER_LOGIN ?> </label>
                        </div>
                        <div class="form-group">
                            <p><?= LOST_PASSWORD ?></p>
                        </div>
                        <input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?= $_GET['ref'] ?>" />
                        <input type="submit" name="submit" class="btn btn-primary" id="btnLOgin" value="<?= LOGIN ?>" />

                    </form>